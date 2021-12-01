def main(inputstr):
    inputs = inputstr.split("\n")
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return [ans1,ans2]

def part1(inputs):
    prev = 0
    increased = -1 # To negate the first inevitable increase, that doesn't count
    for inp in inputs:
        inp = int(inp)
        if inp > prev:
            increased += 1
        prev = inp
    return increased

def part2(inputs):
    increased = -1  # Again, the first window will certainly increase, but doesn't count
    prev = 0
    for i in range(0,len(inputs)-2):
        window_sum = int(inputs[i]) + int(inputs[i+1]) + int(inputs[i+2])
        if window_sum > prev:
            increased += 1
        prev = window_sum
    return increased