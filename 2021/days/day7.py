import numpy as np

def main(inputstr):
    inputs = np.array(list(map(int, inputstr.split(","))))
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return ans1, ans2


def part1(inputs):
    # Iterate all possible positions in an attempt to find the most fuel efficient one
    minfuel = np.inf
    for i in np.arange(min(inputs),max(inputs)+1):  # The optimal position is obviously between the min and max of where any of the crabs are already
        fuel = sum(abs(inputs - i))
        minfuel = min(fuel, minfuel)
    return minfuel

def part2(inputs):
    # Iterate all possible positions in an attempt to find the most fuel efficient one
    minfuel = np.inf
    for i in np.arange(min(inputs),max(inputs)+1):  # The optimal position is obviously between the min and max of where any of the crabs are already
        steps = abs(inputs - i)
        fuel = int(np.sum(steps*(steps+1)/2))      # sum(range(n)) = n*(n+1) / 2
        minfuel = min(fuel, minfuel)
    return minfuel