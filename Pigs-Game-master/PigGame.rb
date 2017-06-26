#Pigs Hold at 20
#Tom Tibble and Kevin

player_total = 0
cpu_total = 0
turn_count = rand(2)
until player_total >= 100 or cpu_total >= 100   #game loop

	round_total =0

	if turn_count % 2 == 0 			#if turn count is even, cpu's turn is processed
	puts("CPU's turn.")
		until round_total  >= 20 or (round_total +cpu_total >= 100)
			roll = rand(6) + 1
			puts("Roll: #{roll}")
			if roll == 1
				round_total = 0
				break
			end
			round_total += roll
		end
		puts("CPU round total: #{round_total}")
		cpu_total += round_total
			                                    # End of cpu's Turn
	


	else
	puts("It is your turn.")
		until (round_total + player_total >= 100)	 # else statement for Player's turn
			
			roll = rand(6) + 1
			puts("Roll: #{roll}")
			if roll == 1
				puts "You rolled a 1, you receive 0 points for the round."
				round_total = 0
				break
			end
			round_total += roll
			print "Turn total: #{round_total}   Press Enter to continue, or any key to hold. "
			input = gets.chomp
			
			if input == ""
			else
				break
			end
			
		end

		puts("Player round total: #{round_total}")
		player_total += round_total
	end


	puts("Your score: #{player_total}")
	puts("CPU's score: #{cpu_total}")
	puts()
	if player_total>= 100
		puts ("YOU WIN!!!")
	elsif cpu_total >= 100
		puts("You have been defeated...")
	else
		puts ("Press enter for next turn.")
	end
	gets.chomp
	turn_count += 1
end
