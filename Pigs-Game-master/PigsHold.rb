#Pigs Hold at 20
#Tom Tibble and Kevin

round_total = 0
until round_total  >= 20

	roll = rand(6) + 1
	puts("Roll: #{roll}")

	if roll == 1
		round_total = 0
		break
	end
	round_total += roll
end
puts("Round total: #{round_total}")

