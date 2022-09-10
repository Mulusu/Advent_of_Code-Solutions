#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include "../days.h"

int part1(FILE* input){
	int answer = 0;
	char buffer[256];
	while(fgets(buffer,256,input)){
		buffer[strcspn(buffer, "\n")] = 0;
		int change = atoi(buffer);
		answer += change;
	}
	return answer;
}

typedef struct LinkedList{
	int value;
	void* next;
} linked;

// Free the allocated memory
void clean(linked* list){
	linked* nextptr = list;
	while (nextptr != NULL){
		linked* thisptr = nextptr;
		nextptr = thisptr->next;
		free(thisptr);
	}
}

int part2(FILE* input){
	int answer = 0;
	int current_pos = 0;
	int has_answer = 0;
	linked* list = malloc(sizeof(linked));
	list->value = current_pos;
	list->next = NULL;
	
	while(has_answer == 0){
		rewind(input); // Reset
		char buffer[256];
		while(fgets(buffer,256,input)){
			buffer[strcspn(buffer, "\n")] = 0;
			int change = atoi(buffer);
			current_pos += change;
			
			// Check the list if we have been here already
			linked* curlist = list;
			while(1){
				// If not yet in the list, append this position to the end
				if (curlist->next == NULL){
					linked* newEntry = malloc(sizeof(linked));
					newEntry->value = current_pos;
					curlist->next = newEntry;
					newEntry->next = NULL;
					break;
				}
				
				if (curlist->value == current_pos){
					has_answer = 1;
					answer = current_pos;
					
					clean(list);
					
					return answer;
				}
				
				curlist = curlist->next;
			}
		}
	}
	return answer;
}

struct Answers day1(FILE* input){
	struct Answers answer;
	answer.part1 = part1(input);
	answer.part2 = part2(input);
	return answer;
}