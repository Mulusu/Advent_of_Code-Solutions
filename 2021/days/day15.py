import numpy as np

def main(inputstr):
    inputs = inputstr.split("\n")
    riskmap = np.zeros((len(inputs) , len(inputs[0] )), dtype=int)
    for i in range(len(inputs)):
        row = [int(c) for c in list(inputs[i])]
        riskmap[i] = row
    ans1 = part1(riskmap)
    ans2 = part2(riskmap)
    return ans1, ans2

# Map the smallest total risk it takes to move to each position on the map from start
def map_risks(riskmap):
    datatype = np.uint16 # Using smaller datatype than the default cuts some seconds from runtime
    bignum = np.iinfo(datatype).max # Just a big number to fill the arrays with in the beginning

    risk = np.full((riskmap.shape[0], riskmap.shape[1]), bignum,dtype=datatype)
    risk[0,0] = 0
    r = np.full([4,riskmap.shape[0], riskmap.shape[1]], bignum, dtype=datatype)
    while True:
        r[0,1:,:] = risk[0:-1,:]         # Shitf one down
        r[1,:,1:] = risk[:,0:-1]         # Shift one right
        r[2,:-1,:] = risk[1:,:]          # Shirt one up
        r[3,:,:-1] = risk[:,1:]          # Shift one left
        newmin = np.min(r,axis=0) + riskmap
        mask = risk > newmin
        if not mask.any(): # No change, return
            return risk
        risk[mask] = newmin[mask]


def part1(riskmap):
    risks = map_risks(riskmap)
    return int(risks[-1,-1])


def part2(riskmap):
    maxx = riskmap.shape[0]
    maxy = riskmap.shape[1]
    large_map = np.zeros((maxx*5, maxy*5), dtype=int)
    for x in range(5):
        for y in range(5):
            newchunc = riskmap + x + y
            large_map[x*maxx:(x+1)*maxx, y*maxy:(y+1)*maxy] = newchunc
    large_map[large_map > 9] -= 9
    risks = map_risks(large_map)
    return int(risks[-1,-1])