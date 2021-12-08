
def main(inputstr):
    inputs = inputstr.split("\n")
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return [ans1,ans2]

def part1(inputs):
    x = 0
    y = 0
    for com in inputs:
        dir, amount = com.split(" ")
        if dir == "forward":
            x += int(amount)
        elif dir == "down":
            y += int(amount)
        elif dir == "up":
            y -= int(amount)
    return x * y

def part2(inputs):
    x = 0
    y = 0
    aim = 0
    for com in inputs:
        dir, amount = com.split(" ")
        if dir == "forward":
            x += int(amount)
            y += aim * int(amount)
        elif dir == "down":
            aim += int(amount)
        elif dir == "up":
            aim -= int(amount)
    return x * y
    