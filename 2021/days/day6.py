
def main(inputstr):
    timers = list(map(int, inputstr.split(","))) # Split input and convert to ints
    # There are only 9 (0-8) possible states for the lanternfish
    # Instead of simulating each, we just track how MANY of each state we have
    # and shuffle and increment those numbers accordingly.
    states = [0] * 9            # Allocate zeros for all states
    for i in range(9):
        states[i] = timers.count(i)
    ans1 = part1(states.copy()) # Copy so we don't overwrite the original (need that in part2!)
    ans2 = part2(states)
    return ans1, ans2


def simulate_lanternfish(days : int, states : list):
    for i in range(days):
        atzero = states.pop(0)
        states[6] += atzero # The old ones reset their timer to 6
        states.append(atzero) # Spawn new ones at the last state
    return sum(states)

def part1(states):
    return simulate_lanternfish(80, states)

def part2(states):
    return simulate_lanternfish(256,states)