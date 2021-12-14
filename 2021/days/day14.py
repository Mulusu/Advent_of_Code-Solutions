import re

def main(inputstr):
    template, rulesstr = inputstr.split("\n\n")
    rules = {}
    for i in rulesstr.split("\n"):
        pair,fill = i.split(" -> ")
        rules[pair] = fill
    ans1 = part1(template, rules)
    ans2 = part2(template, rules)
    return ans1, ans2

def pair_insert(template,rules,steps):
    for _ in range(steps):
        new_tmplt = ""
        for i in range(len(template)-1):
            pair = template[i]+template[i+1]
            if pair in rules.keys():
                new_tmplt += pair[0]
                new_tmplt += rules[pair]
            else:
                new_tmplt += pair[0]
        new_tmplt += template[-1]
        template = new_tmplt
    return template

def part1(template, rules, steps = 10):
    template = pair_insert(template,rules,steps)
    
    # Find max and min
    times = {}
    for i in range(len(template)):
        char = template[i]
        if char in times.keys():
            times[char] += 1
        else:
            times[char] = 1
    vals = list(times.values())
    vals.sort()
    res = vals[-1] - vals[0]
    return res

def part2(template, rules):
#    res = part1(template,rules,40)
    return "Not yet done"