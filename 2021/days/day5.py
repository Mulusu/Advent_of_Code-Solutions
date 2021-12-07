import numpy as np


class Vent():
    def __init__(self, start : tuple, end : tuple):
        self.start = start
        self.end = end
        if self.start[0] == self.end[0]:    # Start and end X same
            self.dir = 'vertical'
        elif self.start[1] == self.end[1]:  # Start and end Y same
            self.dir = 'horizontal'
        else:
            self.dir = "diagonal"


class Map():
    def __init__(self, mapsize : int):
        self.map = np.zeros((mapsize,mapsize))

    def add_vent(self, vent : Vent):
        if vent.dir == 'vertical':
            yrange = np.arange(min([vent.start[1],vent.end[1]]), max([vent.start[1],vent.end[1]])+1)
            self.map[vent.start[0],yrange] += 1
        elif vent.dir == 'horizontal':
            xrange = np.arange(min([vent.start[0],vent.end[0]]), max([vent.start[0],vent.end[0]])+1)
            self.map[xrange,vent.start[1]] += 1
        else:
            if vent.start[0] < vent.end[0]:
                xdir = 1
            else: 
                xdir = -1
            if vent.start[1] < vent.end[1]:
                ydir = 1
            else:
                ydir = -1
            length = abs(vent.start[0]-vent.end[0])+1
            xinds = vent.start[0] + np.arange(length) * xdir
            yinds = vent.start[1] + np.arange(length) * ydir
            self.map[xinds , yinds] += 1


    def count_overlaps(self):
        return np.count_nonzero(self.map > 1)


def main(inputsrt : str):
    inputs = inputsrt.replace("\n",",").replace(" -> ",",").split(",")
    nums = list(map(int, inputs)) # Convert string to list of ints (every group of 4 ints is one vent)
    mapsize = max(nums) + 1
    vents = []
    for i in range(len(nums)//4):
        ind = i * 4
        start = (nums[ind],nums[ind+1])
        end = (nums[ind+2],nums[ind+3])
        vents.append(Vent(start,end))
    ventmap = Map(mapsize)
    ans1 = part1(vents, ventmap)
    ans2 = part2(vents, ventmap)
    return ans1,ans2


def part1(vents : list, map : Map):
    for vent in vents:
        if vent.dir == 'diagonal':
            continue        # Only considering straight ones in part 1
        map.add_vent(vent)
    return map.count_overlaps()

def part2(vents : list, map : Map):
    for vent in vents:
        if vent.dir != 'diagonal':
            continue        # Already added to the map in part 1
        map.add_vent(vent)
    return map.count_overlaps()