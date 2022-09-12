#include <vector>
#include <string>
#include <algorithm>
#include <iostream>

using namespace std;

string day4_part1(vector<string>);
string day4_part2(vector<string>);

class GuardEvent{
	public:
		int year;
		int month;
		int day;
		int hour;
		int minute;
		string action;
		int guardnum = 0;
		
		GuardEvent(string inputline){
			year = stoi(inputline.substr(1,4));
			month = stoi(inputline.substr(6,2));
			day = stoi(inputline.substr(9,2));
			hour = stoi(inputline.substr(12,2));
			minute = stoi(inputline.substr(15,2));
			
			// Get the type of event
			if (inputline.find("begins shift") != string::npos){
				action = "shift";
				string numstr = inputline.substr(inputline.find("#")+1,inputline.find(" begins shift")-inputline.find("#"));
				guardnum = stoi(numstr);
			}
			
			if (inputline.find("wakes up") != string::npos){
				action = "wake";
			}
			
			if (inputline.find("falls asleep") != string::npos){
				action = "sleep";
			}
		}
		
		bool operator <(GuardEvent i){
			if (year != i.year){
				return year < i.year;
			}
			if (month != i.month){
				return month < i.month;
			}
			if (day != i.day){
				return day < i.day;
			}
			if (hour != i.hour){
				return hour < i.hour;
			}
			if (minute != i.minute){
				return minute < i.minute;
			}
			return true;
		}
};

class Guard{
	public:
		int slept = 0;
		int number;
		int sleep_time[60];
		
		void calculate_sleep(vector<GuardEvent> events){
			for (int i = 0; i < 60; i++){
				sleep_time[i] = 0;		// Just to be sure
			}
			
			int storage;				// Save the index of falling asleep event for time calc
			for (int i = 0; i < events.size(); i++){
				GuardEvent e = events[i];
				if (events[i].guardnum != number){
					continue;				// Not our event
				}
				if(events[i].action.compare("shift") == 0){
					continue; 				// Not interested in starting of shift
				}
				if (events[i].action.compare("sleep") == 0){
					storage = i;
				}
				if (events[i].action.compare("wake") == 0){
					for (int s = events[storage].minute; s < events[i].minute; s++){
						sleep_time[s] += 1;
						slept++;
					}
				}
			}
		}
		
		Guard(vector<GuardEvent> events, int num){
			number = num;
			calculate_sleep(events);
		}
};

vector<string> day4(vector<string> input){
	vector<string> answer;
	answer.push_back(day4_part1(input));
	answer.push_back(day4_part2(input));
	return answer;
}

vector<GuardEvent> get_events(vector<string> input){
	vector<GuardEvent> events;
	for(int i = 0; i < input.size(); i++){
		events.push_back(GuardEvent(input[i]));
	}
	sort(events.begin(),events.end());
	
	int num = 0;
	for (int i = 0; i < events.size(); i++){
		if (events[i].action.compare("shift") == 0){
			num = events[i].guardnum;
		}
		else{
			events[i].guardnum = num;
		}
	}
	return events;
}

vector<Guard> get_guards(vector<GuardEvent> events){
	vector<Guard> guards;
	for (int i = 0; i < events.size(); i++){
		bool is = false;
		for (int g = 0; g < guards.size(); g++){
			if (guards[g].number == events[i].guardnum){
				is = true;
				break;		// This guard is already on the list
			}
		}
		if (!is){
			guards.push_back(Guard(events,events[i].guardnum));
		}
	}
	return guards;
}

string day4_part1(vector<string> input){
	vector<GuardEvent> events = get_events(input);
	vector<Guard> guards = get_guards(events);
	
	Guard sleepiest = guards[0];
	for (int i = 1; i < guards.size(); i++){
		if (guards[i].slept > sleepiest.slept){
			sleepiest = guards[i];
		}
	}
	int max = 0;
	for (int i = 0; i < 60; i++){
		if(sleepiest.sleep_time[i] > sleepiest.sleep_time[max]){
			max = i;
		}
	}
	return to_string(sleepiest.number * max);
}

string day4_part2(vector<string> input){
	vector<GuardEvent> events = get_events(input);
	vector<Guard> guards = get_guards(events);
	
	int time = 0;
	Guard guard = guards[0];
	
	for (int g = 0; g < guards.size(); g++){
		for (int m = 0; m < 60 ; m++){
			int val = guards[g].sleep_time[m];
			if (val > guard.sleep_time[time]){
					guard = guards[g];
					time = m;
			}
		}
	}
	return to_string(guard.number * time);
}