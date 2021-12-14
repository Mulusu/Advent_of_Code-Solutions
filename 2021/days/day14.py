def main(inputstr):
    template, rulesstr = inputstr.split("\n\n")
    rules = {}
    for i in rulesstr.split("\n"):
        pair,fill = i.split(" -> ")
        rules[pair] = [pair[0]+fill,fill+pair[1]]   # The new pairs that will be formed by this rule
    ans1 = part1(template, rules)
    ans2 = part2(template, rules)
    return ans1, ans2


def pair_insert(pairs,rules,steps):
    for _ in range(steps):
        newpairs = {}
        for key in pairs.keys():                    # For every pair in the old string...
            for insert in rules[key]:               # For every new pair that is formed by the rule it matches
                if insert in newpairs.keys():       # Count the number that new pair will be in the new string
                    newpairs[insert] += pairs[key]
                else:
                    newpairs[insert] = pairs[key]
        pairs = newpairs
    return pairs


def part1(template, rules, steps = 10):
    # Build the pairs from the template
    pairs = {}
    for i in range(len(template)-1):
        newpair = template[i]+template[i+1]
        if newpair in pairs.keys():
            pairs[newpair] += 1
        else:
            pairs[newpair] = 1

    # Insert new elements according to rules
    pairs = pair_insert(pairs,rules,steps)
    
    # Find max and min
    times = {}
    for key in pairs.keys():
        char = key[0]
        if char in times.keys():
            times[char] += pairs[key]
        else:
            times[char] = pairs[key]
    times[template[-1]] += 1 # Last character of template is not counted yet
    vals = list(times.values())
    vals.sort()
    res = vals[-1] - vals[0]
    return res


def part2(template, rules):
    res = part1(template,rules,40)  # Part 1 has everything, just call it
    return res
