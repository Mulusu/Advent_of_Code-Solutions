def main(inputstr):
    inputs = [i.split("-") for i in inputstr.split("\n")]
    map = {}
    for i in range(len(inputs)):
        if inputs[i][0] in map.keys():
            map[inputs[i][0]].append(inputs[i][1])
        else:
            map[inputs[i][0]] = [inputs[i][1]]
        if inputs[i][1] in map.keys():
            map[inputs[i][1]].append(inputs[i][0])
        else:
            map[inputs[i][1]] = [inputs[i][0]]
    ans1 = part1(map)
    ans2 = part2(map)
    return ans1, ans2

def map_caves(map, current, visited, small_visited):
    if current.islower():
        visited.append(current)
    next = map[current]
    routes = 0
    for n in next:
        if n == 'start':        # Can't go back to start
            continue
        if n == 'end':          # One possible route found!
            routes += 1
            continue
        if n in visited:
            if not small_visited:
                routes += map_caves(map, n, visited.copy(), True)
            continue
        routes += map_caves(map, n, visited.copy(), small_visited)
    return routes

def part1(map):
    return map_caves(map, 'start', [], True)

def part2(map):
    return map_caves(map, 'start', [], False)
