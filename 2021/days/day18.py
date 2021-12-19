from math import floor, ceil

def main(inputstr):
    inputs = inputstr.split("\n")
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return ans1, ans2


class Pair:
    def __init__(self, contents):
        left = contents[0]
        right = contents[1]
        if type(left) == int or type(left) == Pair:
            self.left = left
        else:
            self.left = Pair(left)
        if type(right) == int or type(right) == Pair:
            self.right = right
        else:
            self.right = Pair(right)


    def reduce(self):
        while True:
            res = self.explode(0)
            if res[0]:
                continue
            res = self.split()
            if res:
                continue
            break


    def explode(self, depth):
        if depth > 3:
            return True, self.left, self.right, True

        if type(self.left) == Pair:
            res = self.left.explode(depth+1)
            if res[0]:
                if res[1] is not None and res[3]:
                    self.left = 0
                if res[2] is not None:
                    if type(self.right) == int:
                        self.right += res[2]
                    else:
                        self.right.addleft(res[2])
                return True, res[1], None, False

        if type(self.right) == Pair:
            res = self.right.explode(depth+1)
            if res[0]:
                if res[2] is not None and res[3]:
                    self.right = 0
                if res[1] is not None:
                    if type(self.left) == int:
                        self.left += res[1]
                    else:
                        self.left.addright(res[1])
                return True, None, res[2], False

        return False, None, None


    def addleft(self,num):
        if type(self.left) == int:
            self.left += num
        else:
            self.left.addleft(num)


    def addright(self, num):
        if type(self.right) == int:
            self.right += num
        else:
            self.right.addright(num)


    def split(self):
        if type(self.left) == int:
            if self.left > 9:
                newl = floor(self.left / 2)
                newr = ceil(self.left / 2)
                self.left = Pair([newl, newr])
                return True
        else:
            res = self.left.split()
            if res:
                return True

        if type(self.right) == int:
            if self.right > 9:
                newl = floor(self.right / 2)
                newr = ceil(self.right / 2)
                self.right = Pair([newl, newr])
                return True
        else:
            res = self.right.split()
            if res:
                return True
        return False


    def magnitude(self):
        if type(self.left) == int:
            lmag = 3*self.left
        else:
            lmag = 3*self.left.magnitude()
        if type(self.right) == int:
            rmag = 2*self.right
        else:
            rmag = 2*self.right.magnitude()
        return lmag + rmag

    def __str__(self):
        return f"[{self.left},{self.right}]"


def part1(inputs):
    contents = eval(inputs[0])
    pair = Pair(contents)

    for input in inputs[1:]:
        contents = eval(input)
        newpair = Pair(contents)
        pair = Pair([pair,newpair])
        pair.reduce()
    return pair.magnitude()


def part2(inputs):
    maxmag = 0
    for x in range(len(inputs)):
        for y in range(len(inputs)):
            if x == y:
                continue
            left = Pair(eval(inputs[x]))
            right = Pair(eval(inputs[y]))
            pair = Pair([left,right])
            pair.reduce()
            mag = pair.magnitude()
            if mag > maxmag:
                maxmag = mag
    return maxmag
