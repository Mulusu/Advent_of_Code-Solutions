#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include "../odddays.h"

char *index(const char *s, int c);

typedef struct Claim{
	int number;
	int startx;
	int starty;
	int endx;
	int endy;
} claim;


claim* parse_claims(FILE* input){
	int count = 0;
	claim* claims = NULL;
	char buffer[5];
	int index = 0;		// Index of buffer to write next
	while(1){
		char c = fgetc(input);
		if (c == EOF) {break;} 			// EOF
		if (c == ' ') {continue;}		// Useless white space
		
		if (c == '#') {					// Start of new claim
			claims = realloc(claims,(count+1)*sizeof(claim)); // Allocate space for old + 1 more
			if (claims == NULL){printf("ERROR: Allocation of memory failed!!!\n"); exit(-1);}
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
			continue;
		}
		
		if (c == '@'){
			claims[count].number = atoi(buffer);
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
			continue;
		}
		
		if (c == ','){
			claims[count].startx = atoi(buffer);
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
			continue;
		}
		
		if (c == ':'){
			claims[count].starty = atoi(buffer);
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
			continue;
		}
		
		if (c == 'x'){
			claims[count].endx = claims[count].startx + atoi(buffer);
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
			continue;
		}
		
		if (c == '\n'){
			claims[count].endy = claims[count].starty + atoi(buffer);
			count++;
			index = 0;
			for(int i = 0; i < 5; i++){buffer[i] = '\0';}		// Swipe the buffer clean
		}
		buffer[index] = c;
		index++;
	}
	claims = realloc(claims,(count+1)*sizeof(claim));
	claims[count].number = -1;	// To know where the array ends
	return claims;
}

int findmax(claim* claims){
	int max = 0;
	for ( int i = 0; claims[i].number != -1; i++){
		if (claims[i].endx > max){
			max = claims[i].endx;
		}
		if (claims[i].endy > max){
			max = claims[i].endy;
		}
	}
	return max;
}


int day3_part1(claim* claims){
	int max = findmax(claims);
	int map[max][max];
	for (int x = 0; x < max ; x++){
		for (int y = 0; y < max ; y++){
			map[x][y] = 0;
		}
	}

	int answer = 0;
	
	for ( int i = 0; claims[i].number != -1; i++){
		for (int x = claims[i].startx; x < claims[i].endx; x++){
			for (int y = claims[i].starty; y < claims[i].endy; y++){
				map[x][y]++;
				if (map[x][y] == 2){ // We JUST pushed it over the threshold
					answer++;
				}
			}
		}
	}

	return answer;
}

int day3_part2(claim* claims){
	int max = findmax(claims);
	int map[max][max];
	for (int x = 0; x < max ; x++){
		for (int y = 0; y < max ; y++){
			map[x][y] = 0;
		}
	}
	
	for ( int i = 0; claims[i].number != -1; i++){
		for (int x = claims[i].startx; x < claims[i].endx; x++){
			for (int y = claims[i].starty; y < claims[i].endy; y++){
				map[x][y]++;
			}
		}
	}
	
	for (int i = 0; claims[i].number != -1; i++){
		int valid = 1;
		for (int x = claims[i].startx; x < claims[i].endx; x++){
			for (int y = claims[i].starty; y < claims[i].endy; y++){
				if (map[x][y] > 1){
					valid = 0;
					break;
				}
			}
			if (valid == 0){
				break;
			}
		}
		if (valid == 1){
			return claims[i].number;
		}
	}
	return -1;
}

struct Answers day3(FILE* input){
	struct Answers answer;
	claim* claims = parse_claims(input);
	answer.part1 = day3_part1(claims);
	answer.part2 = day3_part2(claims);
	free(claims);
	return answer;
}