#ifndef __Model3D_H__
#define __Model3D_H__

#include <vector>
#include "Frog.h"
class Model3D
{
public:
	Webfoot::Point2F viewMax;  // viewport max and min values
	Webfoot::Point2F viewMin;
	Webfoot::Point2F viewBotRight;  // viewport bounding points
	Webfoot::Point2F viewTopLeft;

	Webfoot::Point2F winMax;  // viewport max and min values
	Webfoot::Point2F winMin;
	Webfoot::Point2F winBotRight;  // viewport bounding points
	Webfoot::Point2F winTopLeft;

	Webfoot::Point2F windowMax;
	Webfoot::Point2F windowMin;

	int size;
	std::vector<Webfoot::Point3F> worldPts;
	std::vector<Webfoot::Point2F> windowPts;

	bool stereo3D;
	bool test3D;
	std::vector<Webfoot::Point2F> StereoPtsRight;  // will be used if steroscopic 3d is implimented. 
	std::vector<Webfoot::Point2F> StereoPtsLeft;

	Model3D();
	~Model3D();


	void readFile(); // reads input and sets world coordinates , currently sets viewport coords.

	void ProjectView(); // future function for viewport projection

	void StereoProject(); // Stereo Projection

	void draw();   // draws to screen

	void StereoDraw(); // draws a stereoscopic perpsective projection

	void rotateX(float);  // rotates object in x axis by degree

	void rotateY(float);  // rotates object in y axis by degree

	void rotateZ(float);  // rotates object in z axis by degree

	void zoom(float);    // Zooms in object

	void translate(int, int); // moves window coordinates by given increments

	void moveVP(int, int);  // move Viewport

	void sizeVP(float);   // resize Viewport
};

#endif //#ifndef __Model3D_H__