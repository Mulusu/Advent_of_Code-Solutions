import numpy as np

def main(inputstr):
    lines = inputstr.split("\n")
    ans1 = part1(lines)
    ans2 = part2(lines)
    return ans1, ans2

def part1(lines):
    # Split only the end of lines after | and take the length of the elements there
    end_lens = np.array([len(i) for line in lines for i in line.split(" | ")[1].split(" ")])
    summa = np.count_nonzero(end_lens == 2)     # number 1, since only it has 2 segments
    summa += np.count_nonzero(end_lens == 3)    # number 7, since only it has 3 segments
    summa += np.count_nonzero(end_lens == 4)    # number 4, since only it has 4 segments
    summa += np.count_nonzero(end_lens == 7)    # number 8, since only it has 7 segments
    return  summa

def part2(lines):
    summa = 0
    options = ["a","b","c","d","e","f","g"]
    for line in lines:
        solved = {"abcdefg" : '8'} # Dict of known decodings
        segs = ["".join(sorted(i)) for i in line.split(" | ")[0].split(" ")]
        
        one = [i for i in segs if len(i) == 2][0]
        solved[one] = '1'

        four = [i for i in segs if len(i) == 4][0]
        solved[four] = '4'

        seven = [i for i in segs if len(i) == 3][0]
        solved[seven] = '7'
        
        zerosixnines = [i for i in segs if len(i) == 6]
        zerosixninefound = np.array([0,0,0])
        for i in zerosixnines:
            if zerosixninefound.all():
                break
            notnine = False
            for n in options:
                # Zero
                if not n in i and n in four and not n in one:
                    zero = i
                    zerosixninefound[0] = 1
                    solved[i] = '0'
                    notnine = True
                    break
                
                # Six
                elif not n in i and n in one:
                    six = i
                    zerosixninefound[1] = 1
                    solved[i] = '6'
                    notnine = True
                    break

            if not notnine:
                nine = i
                solved[i] = '9'
                zerosixninefound[2] = 1

        twothreefives = [i for i in segs if len(i) == 5]
        twothreefivefound = np.array([0,0,0])
        for i in twothreefives:
            if twothreefivefound.all():
                break
            notthree = False
            for n in options:
                # Five
                if not n in i and not n in six:
                    five = i
                    twothreefivefound[2] = 1
                    solved[i] = '5'
                    notthree = True
                    break
                
                # Two
                elif not n in i and n in one:
                    two = i
                    twothreefivefound[0] = 1
                    solved[i] = '2'
                    notthree = True
                    break
            if not notthree:
                three = i
                twothreefivefound[1] = 1
                solved[i] = '3'
        end = [solved["".join(sorted(i))] for i in line.split(" | ")[1].split(" ")]
        summa += int("".join(end))
    return summa
   