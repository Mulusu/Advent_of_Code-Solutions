#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include "../odddays.h"

int* parse_changes(FILE* input){
	int count = 1;
	int* changes = NULL;
	while(1){
		char buffer[256];
		char* ret = fgets(buffer, 256, input);
		if (ret == NULL){
			return changes;		// EOF
		}
		buffer[strcspn(buffer, "\n")] = 0;
		changes = realloc(changes,(count+1)*sizeof(int));
		changes[count] = atoi(buffer);
		changes[0] = count;
		count++;
	}
	return changes;
}

int day1_part1(int* changes){
	int answer = 0;
	for (int i = 1; i <= changes[0]; i++){
		answer += changes[i];
	}
	return answer;
}



typedef struct LinkedList{
	int value;
	void* next;
} linked;

int day1_part2(int* changes){
	int answer = 0;
	int current_pos = 0;
	int* poslist = malloc(sizeof(int));
	poslist[0] = current_pos;
	int lenpos = 1;
	
	while(1){
		for (int i = 1; i <= changes[0]; i++){
			current_pos += changes[i];
			
			// Check the list if we have been here already
			for (int x = 0; x < lenpos; x++){
				if (poslist[x] == current_pos){		// We have been here before
					answer = current_pos;
					free(poslist);
					return answer;
				}
			}
			// Add new value to list of positions
			lenpos++;
			poslist = realloc(poslist, lenpos*sizeof(int));
			poslist[lenpos-1] = current_pos;
		}
	}
	return answer;
}

struct Answers day1(FILE* input){
	struct Answers answer;
	int* changes = parse_changes(input);
	answer.part1 = day1_part1(changes);
	answer.part2 = day1_part2(changes);
	return answer;
}