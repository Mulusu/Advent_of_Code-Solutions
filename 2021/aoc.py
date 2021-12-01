import os
import importlib
import sys

def main(argv):
    # If we got a number as parameter, run only that day
    if len(argv) > 1:
        daynums = [int(argv[1])]
        
    else:
        daynums = range(1,25)
    
    # If no number was provided as a parameter, run all the days (that a solution exists for)
    for i in daynums:
        if os.path.exists(f"days/day{i}.py"):
            daycode = importlib.import_module(f"days.day{i}")
            inputs = open(f"inputs/input{i}.txt").read()
            res = daycode.main(inputs)
            print(f"Day {i}\n    Part 1: {res[0]}\n    Part 2: {res[1]}")
        else:
            print(f"Day {i} not yet solved")
    
if __name__ == "__main__":
    main(sys.argv)