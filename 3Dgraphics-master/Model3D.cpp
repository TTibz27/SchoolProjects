#include "Model3D.h"
#include "Frog.h"
#include "MainGame.h"
#include "MainUpdate.h"

#include <fstream>
#include <iostream>
#include <string>
#include <sstream>
using namespace Webfoot;
Model3D::Model3D()
{

winMax = Point2F::Create(1024, 768);
winMin = Point2F::Create(0, 0);
winBotRight = Point2F::Create(winMax.x, winMin.y);
winTopLeft = Point2F::Create(winMin.y, winMax.y);

viewMax = Point2F::Create(1024, 768);
viewMin = Point2F::Create(0, 0);
viewBotRight = Point2F::Create(viewMax.x, viewMin.y);
viewTopLeft = Point2F::Create(viewMin.y, viewMax.y);

stereo3D = false;

}


Model3D::~Model3D()
{
}
void Model3D::readFile(){     // Reads data from file into the Model 3D object

	std::string line;
	std::string input;
	std::stringstream ss;
	float x, y, z;
	size = 0;

	std::ifstream inFile("PIXA.DAT");     
	if (inFile.is_open())
	{
		while (getline(inFile, line))        // Scans Line by line to parse values for X, Y, and Z cordinates.
		{
			if (line.find('J') != line.npos){   
				x = -99999;
				y = -99999;
				z = -99999;
				DebugPrintLinef(" JUMP FOUND");     
			}
			else {
				std::stringstream ss(line);
				ss >> x;
				ss >> y;
				ss >> z;		
			}

			size++; // counts the number of points in the file. 
			worldPts.resize(size);
			worldPts[size - 1] = Webfoot::Point3F::Create(x, y, z);  // creates a webfoot 3f in newly allocated position


			/*window to viewport mapping*/
			//still needs to be adjusted to project
			windowPts.resize(size);
			
			StereoPtsLeft.resize(size);
			StereoPtsRight.resize(size);

			if (x < -9000){                                                       
				windowPts[size - 1] = Webfoot::Point2F::Create(-9999, -9999);
				StereoPtsLeft[size - 1] = Webfoot::Point2F::Create(-9999, -9999);
				StereoPtsRight[size - 1] = Webfoot::Point2F::Create(-9999, -9999);
			}
	
		}

		inFile.close();
	}
	
	else DebugPrintf( "Unable to open polygon data file.");
}

void Model3D::draw(){
	 std::vector < unsigned int > clipByte;
	 clipByte.resize(size);   // makes an array of unsigned intergers for binary operations
	 for (int i = 1; i < size; i++) clipByte[i] = 0;  // initializes bits to zero



	// CLIPPING
	// using each bit for:   0       0        0      0      0     0      0     0 
	//                      Jump   Unused  Unused  Unused  Above  Below  Left   Right

	for (int i = 0; i < size; i++){
		clipByte[i] = 0x00;

		if (windowPts[i].x < -8888){
			clipByte[i] += 0x80;          // 1000 0000 in hex
		}
		if (windowPts[i].y < viewMin.y){  // 0000 1000 in hex
			clipByte[i] += 0x8;
		}
		if(windowPts[i].y > viewMax.y){
			clipByte[i] += 0x4;           // 0000 0100  in hex
		}
		
		if (windowPts[i].x < viewMin.x){  // 0000 0010 in hex
			clipByte[i] += 0x2;
		}
		
		if (windowPts[i].x > viewMax.x){  // 0000 0001 in hex
			clipByte[i] += 0x1;
		}
	}

	for (int i = 1; i < size; i++){
		 
		if (clipByte[i - 1] < 0x80  && clipByte[i] < 0x80)
		{
			if (clipByte[i - 1] == 0x00 && clipByte[i] == 0x00)
			{   // Trivial accept: draws lines that are entirely contained by viewport
				theScreen->LineDraw(windowPts[i - 1], windowPts[i], COLOR_RGBA8_GREEN, 1.0f, 1.0f);
			}
			else if ((clipByte[i - 1] & clipByte[i]) == 0x00)  // checks for Trivial Reject: if a line has two of the same binary flags, ignore it
			{
				Point2F tempPt;
				Point2F tempPt2;
				unsigned int vertMask = 0x0C; // 0000 1100 hex
				unsigned int horizMask = 0x03; // 0000 0011 hex
				float tempX = 0;
				float tempY = 0;
				float slope;


				if (clipByte[i - 1] == 0x00){                  // first point is within the bounds
					if (clipByte[i] & 0x2){        //  if point is to the left
						tempX = viewMin.x;
						slope = (windowPts[i].y - windowPts[i - 1].y) / (windowPts[i].x - windowPts[i - 1].x);
						tempY = slope * (tempX - windowPts[i].x) + windowPts[i].y;  // y2 = slope * (x2- x1) + y1
					}
					else if (clipByte[i] & 0x1){  // to the right
						tempX = viewMax.x;
						slope = (windowPts[i].y - windowPts[i - 1].y) / (windowPts[i].x - windowPts[i - 1].x);
						tempY = slope * (tempX - windowPts[i].x) + windowPts[i].y;  // y2 = slope * (x2- x1) + y1   // finds y value of temporary point using slope intercept
					}
					
					else if (clipByte[i] & 0x04){ // bottom of screen
						tempY = viewMax.y;
						slope = (windowPts[i].y - windowPts[i - 1].y) / (windowPts[i].x - windowPts[i - 1].x);
						tempX = (tempY - windowPts[i - 1].y) / slope + windowPts[i - 1].x;     //  x = (y2 - y1) / slope  + x1   // finds y value of temporary point using slope intercept
					}
					else if (clipByte[i] & 0x08){ // top of screen
						tempY = viewMin.y;
						slope = (windowPts[i].y - windowPts[i - 1].y) / (windowPts[i].x - windowPts[i - 1].x);
						tempX = (tempY - windowPts[i - 1].y) / slope + windowPts[i - 1].x;     //  x = (y2 - y1) / slope  + x1   // finds y value of temporary point using slope intercept
					}
				tempPt = Point2F::Create(tempX, tempY);
				theScreen->LineDraw(tempPt, windowPts[i - 1], COLOR_RGBA8_ORANGE, 1.0f, 1.0f);
				}



	/* This Section needs editing, lines where both points exist outside of the clipping range but still cross the viewport are not accounted for */

				//else if (clipByte[i] != 0x00 && clipByte[i - 1] != 0x00) {             // neither point is within the bounds
				
				//	if (clipByte[i] ^ 0x2 ==  0x02 ){        // xor, if the point is to the left
				///		tempX = viewMin.x;
				//		slope = (windowPts[i].y - windowPts[i - 1].y) / (windowPts[i].x - windowPts[i - 1].x);
				//		tempY = viewMin.y; //  slope * (tempX - windowPts[i].x) + windowPts[i].y;  // y2 = slope * (x2- x1) + y1
				//	}
				//	theScreen->LineDraw(tempPt, windowPts[i], COLOR_RGBA8_WHITE, 1.0f, 1.0f);
				// }
				
				// theScreen->LineDraw(windowPts[i - 1], windowPts[i], COLOR_RGBA8_RED, 1.0f, 1.0f);
			}
		}
		
	}


	theScreen->LineDraw(winMax, winBotRight, COLOR_RGBA8_YELLOW, 1.0f, 1.0f);    //Window Box
	theScreen->LineDraw(winBotRight, winMin, COLOR_RGBA8_YELLOW, 1.0f, 1.0f);
	theScreen->LineDraw(winMin, winTopLeft, COLOR_RGBA8_YELLOW, 1.0f, 1.0f);
	theScreen->LineDraw(winTopLeft, winMax, COLOR_RGBA8_YELLOW, 1.0f, 1.0f);

	theScreen->LineDraw(viewMax, viewBotRight, COLOR_RGBA8_CYAN, 1.0f, 1.0f);  // Viewport Box
	theScreen->LineDraw(viewBotRight, viewMin, COLOR_RGBA8_CYAN, 1.0f, 1.0f);
	theScreen->LineDraw(viewMin, viewTopLeft, COLOR_RGBA8_CYAN, 1.0f, 1.0f);
	theScreen->LineDraw(viewTopLeft, viewMax, COLOR_RGBA8_CYAN, 1.0f, 1.0f);


}


void Model3D::StereoDraw(){     // Draws a Stereoscopic projection of the object

	for (int i = 1; i < size; i++){
		if (windowPts[i - 1].x > -8888 && windowPts[i].x > -8888){
			theScreen->LineDraw(StereoPtsLeft[i - 1], StereoPtsLeft[i], COLOR_RGBA8_BLUE, 2.0f, 1.0f);
			theScreen->LineDraw(StereoPtsRight[i - 1], StereoPtsRight[i], COLOR_RGBA8_RED, 2.0f, 1.0f);
		}

	}

}
void Model3D::translate(int distX, int distY){
	float viewSizeX, viewSizeY;
	winMax.x += distX;
	winMax.y += distY;
	winMin.x += distX;
	winMin.y += distY;
	winBotRight.x = winMax.x;
	winBotRight.y = winMin.y;
	winTopLeft.x = winMin.x;
	winTopLeft.y = winMax.y;

}

void Model3D::zoom(float inVal){

	winMax.x -= (inVal * (1.024));
	winMax.y -= (inVal * 0.768);

	winBotRight.x = winMax.x;
	winTopLeft.y = winMax.y;


}

void Model3D::ProjectView(){
	// Projects the object with prerspective projection
	//http://en.wikipedia.org/wiki/3D_projection#Perspective_projection

	float newX, newY;
	float x, y, z;

	float k1 = 4000; // distance from center of projection to projection plane 
	float k2 = 4000;

	for (int i = 0; i < size; i++){

		if (worldPts[i].x > -8888)
		{
			x = worldPts[i].x;  
			y = worldPts[i].y ;
			z = worldPts[i].z ;

			newX = k1  *((x / (z + k1)));   // new projected points in world coord system
			newY = (k2 * (y / (z + k2)));

			newX = newX + 2000;                        
			newY = 2000 - newY ;
			newX = winMin.x + (newX*((winMax.x - winMin.x) / 4000));
			newY = winMin.y + (newY *((winMax.y - winMin.y) / 4000));
			

			windowPts[i] = Webfoot::Point2F::Create(newX, newY);


		}
		
	} 

}


void Model3D::StereoProject(){
	//   I did not have any red/blue glasses when making this,
	//   when objects are close the distance on screen between the points is farther,
	//   I may have needed to adjust colors or line size to get the 3d effect.
	float newX_L, newY_L, newX_R, newY_R;
	float x, y, z;

	float k1 = 3000; // distance from center of projection to projection plane 
	float k2 = 3000;

	for (int i = 0; i < size; i++){

		if (worldPts[i].x > -8888)
		{
			x = worldPts[i].x;  
			y = worldPts[i].y ;
			z = worldPts[i].z ;

			newX_L = k1  *(((x - 30) / (z + k1)));   // new projected points in world coord system
			newY_L = (k2 * (y / (z + k2)));

			newX_R = k1  *(((x + 30) / (z + k1)));   // new projected points in world coord system
			newY_R = (k2 * (y / (z + k2)));

			newX_L = newX_L + 2000;                  
			newY_L = 2000 - newY_L;
			newX_L = newX_L*((winMax.x - winMin.x) / 4000);
			newY_L = newY_L *((winMax.y - winMin.y) / 4000);

			newX_R = newX_R + 2000;
			newY_R = 2000 - newY_R;
			newX_R = newX_R*((winMax.x - winMin.x) / 4000);
			newY_R = newY_R *((winMax.y - winMin.y) / 4000);
			


			StereoPtsLeft[i] = Webfoot::Point2F::Create(newX_L, newY_L);
			StereoPtsRight[i] = Webfoot::Point2F::Create(newX_R, newY_R);


		}
		
	} 
}


void Model3D::rotateX(float deg){

  float S = FrogMath::Sin(deg);  // Sign and cosign of inputted theta, I used sigle letters for clearity in the matrix defintion
  float C = FrogMath::Cos(deg);

	float matrix[4][4] ={{ 1,  0,    0,  0 },
						 { 0, (C), (-S), 0 },
						 { 0, (S),  (C), 0 },
						 { 0,  0,    0,  1 } };
	float resultVect[4];
	float Val;
	
	for (int i = 0; i < size; i++){
		if (worldPts[i].x > -8888){													// if  the point is valid
			float ptsVect[4] = { worldPts[i].x, worldPts[i].y, worldPts[i].z, 1 };  // takes in world points into vector

			for (int j = 0; j < 4; j++){                                            // multiplies matrix by vector
				Val = 0;
				for (int k = 0; k < 4; k++){
					Val += matrix[k][j] * ptsVect[k];  
				}
				resultVect[j] = Val;                                                // stores in a result array
			}
			worldPts[i].x = resultVect[0];
			worldPts[i].y = resultVect[1];
			worldPts[i].z = resultVect[2];
		}
	}
	

}

void Model3D::rotateY(float deg){


	float S = FrogMath::Sin(deg);  // Sign and cosign of inputted theta, I used sigle letters for clearity in the matrix defintion
	float C = FrogMath::Cos(deg);

	float matrix[4][4] ={{ C,   0, (S), 0 },
	                     { 0,   1,  0 , 0 },
	                     {(-S), 0, (C), 0 },
	                     { 0,   0,  0,  1 } };
	float resultVect[4];
	float Val;

	for (int i = 0; i < size; i++){
		if (worldPts[i].x > -8888){													// if  the point is valid
			float ptsVect[4] = { worldPts[i].x, worldPts[i].y, worldPts[i].z, 1 };  // takes in world points into vector

			for (int j = 0; j < 4; j++){                                            // multiplies matrix by vector
				Val = 0;
				for (int k = 0; k < 4; k++){
					Val += matrix[k][j] * ptsVect[k];
				}
				resultVect[j] = Val;                                                // stores in a result array
			}
			worldPts[i].x = resultVect[0];
			worldPts[i].y = resultVect[1];
			worldPts[i].z = resultVect[2];
		}
	}



}

void Model3D::rotateZ(float deg){


	float S = FrogMath::Sin(deg);  // Sign and cosign of inputted theta, I used sigle letters for clearity in the matrix defintion
	float C = FrogMath::Cos(deg);

	float matrix[4][4] = {  { (C),  (S),  0, 0 },
							{ (-S), (C),  0, 0 },
							{ 0,     0,   1, 0 },
							{ 0,     0,   0, 1 } };
	float resultVect[4];
	float Val;

	for (int i = 0; i < size; i++){
		if (worldPts[i].x > -8888){													// if  the point is valid
			float ptsVect[4] = { worldPts[i].x, worldPts[i].y, worldPts[i].z, 1 };  // takes in world points into vector

			for (int j = 0; j < 4; j++){                                            // multiplies matrix by vector
				Val = 0;
				for (int k = 0; k < 4; k++){
					Val += matrix[k][j] * ptsVect[k];
				}
				resultVect[j] = Val;                                                // stores in a result array
			}
			worldPts[i].x = resultVect[0];
			worldPts[i].y = resultVect[1];
			worldPts[i].z = resultVect[2];
		}
	}



}


void Model3D::moveVP(int inX, int inY){
	viewMax.x += inX;
	viewMax.y += inY;
	viewMin.x += inX;
	viewMin.y += inY;
	viewBotRight.x = viewMax.x;
	viewBotRight.y = viewMin.y;
	viewTopLeft.y = viewMax.y;
	viewTopLeft.x = viewMin.x;

}

void Model3D::sizeVP(float in){
	viewMax.x -= (in * (1.024));
	viewMax.y -= (in * 0.768);

	viewBotRight.x = viewMax.x;
	viewBotRight.y = viewMin.y;
	viewTopLeft.y = viewMax.y;
	viewTopLeft.x = viewMin.x;


}