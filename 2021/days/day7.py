import numpy as np

def main(inputstr):
    inputs = np.array(list(map(int, inputstr.split(","))))
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return ans1, ans2

def part1(inputs):
    options = np.arange(min(inputs), max(inputs)+1)         # Possible positions to consider
    steps = np.stack([abs(inputs - i) for i in options])    # Number of steps to reach each position
    fuel = np.sum(steps, axis=1)                            # Total fuel consumed for moving to any position
    return int(np.min(fuel))                                # Return the lowest total fuel consumption

def part2(inputs):
    options = np.arange(min(inputs), max(inputs)+1)         # Possible positions to consider
    steps = np.stack([abs(inputs - i) for i in options])    # Number of steps to reach each position
    fuel = np.sum((steps*(steps+1))/2, axis=1)              # Total fuel consumed for moving to any position
    return int(np.min(fuel))                                # Return the lowest total fuel consumption
