
def main(inputstr):
    lines = inputstr.split("\n")
    ans1, endings = part1(lines)
    ans2 = part2(endings)
    return ans1, ans2

# Part 1 also returns a bunch of data we need in part 2, since it is already processed once here anyway...
def part1(lines):
    score = 0
    points = {')' : 3, ']' : 57, '}' : 1197, '>' : 25137}
    openings = ['(','[','{','<']
    closings = {'(' : ')','[' : ']','{' : '}','<' : '>'}
    non_corrupted = []
    endings = []
    for line in lines:
        expected_closing = []
        corrupted = False
        for char in list(line):
            if char in openings:
                expected_closing.append(closings[char])
            else:
                expected = expected_closing.pop(-1)
                if expected != char:
                    score += points[char]
                    corrupted = True
                    break
        if not corrupted:
            endings.append(expected_closing.copy()) # The endings needed to complete the line
    return score, endings


def part2(endings):
    points = {')' : 1, ']' : 2, '}' : 3, '>' : 4}
    scores = []
    for end in endings:
        score = 0
        end.reverse()   # It is the wrong way around due to how it was made
        for char in end:
            score = score * 5
            score += points[char]
        scores.append(score)
    scores.sort()
    midind = len(scores)//2
    return scores[midind]
