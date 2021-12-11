import numpy as np

def main(inputstr):
#    inputstr = open("debug.txt").read()
    energies = np.array([list(i) for i in inputstr.split("\n")],dtype=int)
    return solve(energies)

def simulate_flashes(energies):
    has_flashed = np.zeros(energies.shape,dtype=bool)
    energies += 1                                                  # Step1: Increment by one
    to_flash = np.argwhere(energies > 9)                           # Step2: Flash any over 9
    while len(to_flash) > 0:
        for p in to_flash:
            xmin = max(0, p[0]-1)
            xmax = min(9, p[0]+1)
            ymin = max(0, p[1]-1)
            ymax = min(9, p[1]+1)
            energies[xmin:xmax+1,ymin:ymax+1] += 1
            has_flashed[p[0],p[1]] = True
        to_flash = np.argwhere((energies > 9) & (has_flashed == False))
    energies[has_flashed] = 0                                      # Step3: Any that flashed returns to 0


def solve(energies):
    i = 1
    ans1 = 0
    ans2 = None
    while True:
        simulate_flashes(energies)
        if np.count_nonzero(energies) == 0: # All just flashed and reset to zero!
            ans2 = i
        if i < 101:
            ans1 += np.count_nonzero(energies == 0)
        i += 1

        if i > 100 and ans2 is not None:
            return ans1, ans2