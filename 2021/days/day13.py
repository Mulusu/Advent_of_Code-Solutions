import numpy as np

def main(inputstr):
    parts = inputstr.split("\n\n") # Split dots from folds
    dots = []
    for line in parts[0].split("\n"):
        num1, num2 = line.split(",")
        dots.append([int(num1) , int(num2)])
    dots = np.array(dots)
    folds = []
    for line in parts[1].split("\n"):
        axis, coord = line.strip("fold along ").split("=")
        folds.append([axis,int(coord)])

    max_x = np.max(dots[:,0])+1
    max_y = np.max(dots[:,1])+1
    paper = np.zeros((max_x,max_y),dtype=bool)
    paper[dots[:,0],dots[:,1]] = True

    ans1 = part1(paper.copy(), folds)
    ans2 = part2(paper, folds)
    return ans1, ans2

def fold(paper, axis, line):
    if axis == "y":
        afterfold = np.flip(paper[:,line+1:],axis=1)
        foldlen = afterfold.shape[1]
        paper = paper[:,:line]
        paper[:,-foldlen:] = paper[:,-foldlen:] | afterfold
    else:
        afterfold = np.flip(paper[line+1:,:], axis=0)
        foldlen = afterfold.shape[0]
        paper = paper[:line,:]
        paper[-foldlen:,:] = paper[-foldlen:,:] | afterfold
    return paper

def part1(paper, folds):
    paper = fold(paper,folds[0][0],folds[0][1])
    return np.count_nonzero(paper)


def part2(paper, folds):
    for f in folds:
        paper = fold(paper,f[0],f[1])
    res = ""
    for y in range(paper.shape[1]):
        for x in range(paper.shape[0]):
            if paper[x,y]:
                res += "#"
            else:
                res += " "
        res += "\n            " # Lots of padding spaces to make it align nicely with the output printing
    return res
