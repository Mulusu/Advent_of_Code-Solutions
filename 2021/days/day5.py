import numpy as np

class Vent():
    def __init__(self,line):
        points = line.split(" -> ")
        start = points[0].split(",")
        end = points[1].split(",")
        self.start = (int(start[1]),int(start[0]))
        self.end = (int(end[1]),int(end[0]))
        # If straight
        if self.start[0] == self.end[0]:    # Start and end X same
            self.dir = 'vertical'
        elif self.start[1] == self.end[1]:  # Start and end Y same
            self.dir = 'horizontal'
        else:
            self.dir = "diagonal"

class Map():
    def __init__(self,mapsize):
        self.map = np.zeros((mapsize,mapsize))

    def add_vent(self, vent):
        if vent.dir == 'vertical':
            yrange = range(min([vent.start[1],vent.end[1]]), max([vent.start[1],vent.end[1]])+1)
            self.map[vent.start[0],yrange] += 1
        elif vent.dir == 'horizontal':
            xrange = range(min([vent.start[0],vent.end[0]]), max([vent.start[0],vent.end[0]])+1)
            self.map[xrange,vent.start[1]] += 1
        else:
            xdir = -2*int(vent.start[0] > vent.end[0])+1    # 1 if start < end, -1 otherwise
            ydir = -2*int(vent.start[1] > vent.end[1])+1
            for i in range(abs(vent.start[0]-vent.end[0])+1):
                x = vent.start[0] + i * xdir
                y = vent.start[1] + i * ydir
                self.map[x,y] += 1
        

    def count_overlaps(self):
        return (self.map > 1).sum()

def main(inputsrt):
    lines = inputsrt.split("\n")
    vents = []
    mapsize = 0 # So we can allocate just the right size map
    for line in lines:
        vent = Vent(line)
        mnum = max([vent.start[0],vent.start[1],vent.end[0],vent.end[1]])
        if mnum > mapsize:
            mapsize = mnum
        vents.append(vent)
    mapsize += 1
    ans1 = part1(vents, mapsize)
    ans2 = part2(vents, mapsize)
    return ans1,ans2


def part1(vents, mapsize):
    map = Map(mapsize)
    for vent in vents:
        if vent.dir == 'diagonal':
            continue        # Only considering straight ones in part 1
        map.add_vent(vent)
    return map.count_overlaps()

def part2(vents, mapsize):
    map = Map(mapsize)
    for vent in vents:
        map.add_vent(vent)
    print(map.map)
    return map.count_overlaps()