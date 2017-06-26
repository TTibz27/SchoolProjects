#Pigs Hold at 20
#Tom Tibble and Kevin

round_total = 0
print "Enter a hold number:"
hold = gets.chomp
print "Hold-at-20 turn simulations?"
run_count = gets.chomp
hold = hold.to_i
run_count = run_count.to_i
scores = Hash.new(0)

for i in 1..run_count
	until round_total  >= hold

		roll = rand(6) + 1

		if roll == 1
			round_total = 0
			break
		end
		round_total += roll
	end
	scores [round_total] += 1
	round_total = 0
end
puts "Score	Estimated Probability"
scores = Hash[scores.sort_by{|key,value| key}]
scores.each{ |key,value| puts("#{key}	#{((value.to_f/run_count)).round(3)}") }
