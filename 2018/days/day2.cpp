#include <vector>
#include <string>
#include <algorithm>

std::string part1(std::vector<std::string>);
std::string part2(std::vector<std::string>);


std::vector<std::string> day2(std::vector<std::string> input){
	std::vector<std::string> answer;
	answer.push_back(part1(input));
	answer.push_back(part2(input));
	return answer;
}

std::string part1(std::vector<std::string> input){
	int doubles = 0;
	int triples = 0;
	
	std::string alphabet = "abcdefghijklmnopqrstuvwxyz";
	
	for(int i = 0; i < input.size(); i++){
		std::string code = input[i];
		bool haddouble = false;
		bool hadtriple = false;
		for (int y = 0; y < alphabet.length(); y++){
			char c = alphabet[y];
			int found = 0;
			for(int x = 0; x < code.length(); x++){
				if(code[x] == c){
					found++;
				}
			}
			if (found == 2){haddouble = true;}
			if (found == 3){hadtriple = true;}
		}
		if (haddouble){doubles++;}
		if (hadtriple){triples++;}
	}
	return std::to_string(doubles * triples);
}

std::string part2(std::vector<std::string> input){
	for (int x = 0; x < input.size(); x++){
		for (int y = 0; y < input.size(); y++){
			if (x == y) {continue;}
			std::vector<char> matches;
			int diffs = 0;
			for (int c = 0; c < input[x].length(); c++){
				if (input[x][c] != input[y][c]){
					diffs++;
					if (diffs > 1) {break;}
				}
				else{
					matches.push_back(input[x][c]);
				}
			}
			if (diffs == 1){ // Solution found
				std::string answer(matches.begin(),matches.end());
				return answer;
			}
		}
	}
	return "None found";
}