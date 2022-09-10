#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <stdbool.h>
#include "odddays.h"

bool file_exists(char* filename){
	struct stat	buffer;
	return (stat (filename, &buffer) == 0);
}

char* get_filename(int daynum){
	char* filename = malloc(19*sizeof(char));
	sprintf(filename, "inputs/input");
	sprintf(filename+12, "%d", daynum);
	strcat(filename, ".txt");
//	strcat(filename, '\0'); // Ending zero
	return filename;
}

int main(){
	for(int i=1;i<25;i+=2){
		char* filename = get_filename(i);
		if (!file_exists(filename)){
			free(filename);
			continue;
		}

		FILE* file = fopen(filename, "r");
		if (NULL == file){
			printf("Failed to open file!\n");
			return 1;
		}
		struct Answers answer;
		switch(i){		// TODO: replace with a more elegant solution, one has to exist
			case 1:
				answer = day1(file);
				break;
/*			case 3:
				answer = day3(file);
				break;
			case 5:
				answer = day5(file);
				break;
			case 7:
				answer = day7(file);
				break;
*/			default:
				continue;
		}
		free(filename);
		fclose(file);
		printf("Day %d:\n  Part 1: %d\n  Part 2: %d\n",i,answer.part1,answer.part2);
	}
	return 0;
}

