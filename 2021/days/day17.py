from math import sqrt

def main(inputstr):
    target = inputstr.strip("target area: ").replace("x=","").replace(", y="," ").split(" ")
    target = [int(i) for part in target for i in part.split("..")]
    return solve(target)


def fire(velocity, target):
    maxy = 0
    x = 0
    y = 0
    
    #While we havent's exceeded the target coordinates
    while x <= target[1] and y >= target[2]:
        x += velocity[0]
        y += velocity[1]
        if y > maxy:
            maxy = y
        if target[0] <= x <= target[1] and target[2] <= y <= target[3]:
            return True, maxy
        if velocity[0] > 0:
            velocity[0] -= 1
        elif velocity[0] < 0:
            velocity[0] += 1
        velocity[1] -= 1     
    return False, maxy

def solve(target):
    max_y_hit = 0
    successes = 0
    # No reason to fire backwards or so fast it exceeds the target in one step
    for x in range(1,target[1]+1):
        if x*(x+1)//2 < target[0]: # Never going to reach the target in x direction (x+(x-1)+(x-2)+...+1 < target[0])
            continue
        # Smaller or larger y, and it will inevitably miss the target
        for y in range(target[2], abs(target[2])):
            hit, maxy = fire([x,y],target)
            if hit:
                successes += 1
                if maxy > max_y_hit:
                    max_y_hit = maxy
    return max_y_hit, successes
