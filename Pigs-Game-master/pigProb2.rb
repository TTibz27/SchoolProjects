#Pigs Probability Problem 2
#Tom Tibble and Kevin McKoewn

round_total = 0
print "Enter a hold number:"
hold = gets.chomp
hold = hold.to_i

score = Array.new((hold + 5), 0.0)     # intializes array to hold+5 with 0.0 values
score [0] = 1.0

for i in 0...(hold -1)			#loops until Hold value -1
	p = (score[i] / 6)
	score[i] = 0.0
	score[0] += p			# adds running probibilites to apropriate array
	score[i + 2] += p		# values.
	score[i + 3] += p
	score[i + 4] += p
	score[i + 5] += p
	score[i + 6] += p
end

puts "Probablity of 20 = #{score[20]}"   # score[20] should be changed to score[hold], 						 # score [hold +1],score [hold +2], etc.
