import numpy as np

def main(inputstr):
    lines = inputstr.split("\n")
    heightmap = np.array([list(map(int,i)) for i in list(lines)]) # Make it into 100 x 100 array of ints
    ans1 = part1(heightmap)
    ans2 = part2(heightmap)
    return ans1, ans2

def part1(hm):
    risksum = 0
    padded = np.ones((hm.shape[0]+2,hm.shape[1]+2)) * 9
    padded[1:-1,1:-1] = hm
    for x in range(1,hm.shape[0]+1):
        for y in range(1,hm.shape[1]+1):
            surrmin = min(padded[x-1,y], padded[x+1,y], padded[x,y-1], padded[x,y+1])
            if padded[x,y] < surrmin:
                risksum += padded[x,y] + 1
    return int(risksum)


def part2(hm):
    padded = np.ones((hm.shape[0]+2,hm.shape[1]+2)) * 9
    padded[1:-1,1:-1] = hm
    basins = np.zeros((hm.shape[0]+2,hm.shape[1]+2))
    next_basinnum = 1
    pairs = np.argwhere(padded != 9) # Pairs of x and y coords where we know that height is not 9
    for pair in pairs:
        x = pair[0]
        y = pair[1]
        adj1 = basins[x-1,y]
        adj2 = basins[x,y-1]

        if adj1 != 0 and adj2 != 0 and adj1 != adj2:
            basins = np.where(basins == adj1, adj2, basins)
        bnum = max([adj1,adj2])
        if bnum != 0: # ie. if there is a numbered basin
            basins[x,y] = bnum
        else:         # Start a new one then
            basins[x,y] = next_basinnum
            next_basinnum += 1

    sizes = []
    for i in range(1,next_basinnum):
        size = np.count_nonzero(basins == i)
        sizes.append(size)
    sizes.sort()
    return sizes[-1]*sizes[-2]*sizes[-3]