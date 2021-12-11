import os
import importlib
import sys
import time

def main(argv):
    # If we got a number as parameter, run only that day
    if len(argv) > 1:
        daynums = [int(argv[1])]
        
    else:
        daynums = range(1,26)
    
    # If no number was provided as a parameter, run all the days (that a solution exists for)
    for i in daynums:
        if os.path.exists(f"days/day{i}.py"):
            daycode = importlib.import_module(f"days.day{i}")
            inputs = open(f"inputs/input{i}.txt").read().strip()
            starttime = time.time()     # Time the execution, just to get an idea how good/bad the solution is
            res = daycode.main(inputs)
            elapsed = time.time() - starttime

            # So, I figured to add some extra challenge to this:
            # Each day's code should be able to run in under 0.1 seconds (on my machine)
            # Might remove (or up the allowed time) if the complexity of the tasks increase significantly
            assert(elapsed < 0.15)   # Just to cause me suffering

            print(f"Day {i}                           ({elapsed:.4f} s)\n"
                f"    Part 1: {res[0]}\n"
                f"    Part 2: {res[1]}")

        else:
            if i < 26:
                print(f"Day {i} not yet solved")
            else:
                print(f"Day {i} not yet solved... and never will be!")
    
if __name__ == "__main__":
    main(sys.argv)