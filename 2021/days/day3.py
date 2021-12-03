
def main(inputsrt):
    inputs = inputsrt.split("\n")
    ans1 = part1(inputs)
    ans2 = part2(inputs)
    return ans1,ans2


def most_common_bit(inputs, pos):
    # Surely there would be a more elegant way to do this actually using the inputs
    # as actual binary as opposed to strings, but... this works too
    ones = 0
    zeros = 0
    for inp in inputs:
        if inp[pos] == "1":
            ones += 1
        else:
            zeros += 1
    return str(int(ones >= zeros))


def part1(inputs):
    gamma = ""
    epsilon = ""
    for i in range(len(inputs[0])):
        mc = most_common_bit(inputs,i)
        if mc == "1":
            gamma += "1"
            epsilon += "0"
        else:
            gamma += "0"
            epsilon += "1"
    return int(gamma, base=2) * int(epsilon, base=2)

def filter(candidates, mode):
    for i in range(len(candidates[0])): # Iterate all positions
        failed = []
        mc = most_common_bit(candidates,i)
        for ind in range(len(candidates)):
            if candidates[ind][i] == mc and mode == 1:
                failed.append(ind)
            elif candidates[ind][i] != mc and mode == 0:
                failed.append(ind)

        # Remove the failed ones, starting from the end so not to alter indexes of others
        failed.reverse()
        for fi in failed:
            candidates.pop(fi)
        if len(candidates) == 1:
            return candidates[0]

def part2(inputs):
    ogr = filter(inputs.copy(),0)
    csr = filter(inputs.copy(),1)
    return int(ogr, base=2) * int(csr, base=2)