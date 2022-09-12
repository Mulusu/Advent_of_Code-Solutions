#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include "evendays.h"

std::vector<std::string> read_input(int daynum){
	std::ifstream file;
	file.open("inputs/input"+std::to_string(daynum)+".txt");
	std::vector<std::string> input;
	std::string line;
	if (file.is_open()){
		while (std::getline(file,line)){
			if (line.size() > 0){
				input.push_back(line);
			}
		}
	}
	else{
		return input; // Return empty vector, the main function will skip it
	}
	file.close();
	return input;
}

int main(){
	for(int i = 2; i < 25; i+=2){
		std::vector<std::string> input = read_input(i);
		if (input.size() == 0){
			continue;
		}
		std::vector<std::string> answer;
		switch (i){
			case 2:
				answer = day2(input);
				break;
				
			case 4:
				answer = day4(input);
				break;
		}
		std::cout << "Day " << i << "\n  Part1: " << answer[0] << "\n  Part2: " << answer[1] << std::endl;
	}
	return 0;
}