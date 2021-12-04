import numpy as np

def main(inputsrt):
    nums, boardstrs = inputsrt.split("\n",1)
    nums = nums.split(",")
    boardstrs = boardstrs.strip().split("\n\n")
    boards = []
    for b in boardstrs:
        boards.append(Board(b))
    ans1, ans2 = solve(nums, boards)
    return ans1,ans2

class Board:
    def __init__(self,boardstr):
        self.board = np.zeros((5,5),np.int8)
        boardstr = boardstr.split("\n")
        for x in range(5):
            nums = boardstr[x].strip(" ").replace("  "," ").split(" ") # Strip ends of lines, remove double spaces, split
            for y in range(5):
                self.board[x][y] = int(nums[y])
        self.matched = np.zeros((5,5),np.bool)
        self.lastmatch = 0
        self.has_won = False

    # Check if the number is on board and mark it. Return True if this wins the game
    def check(self,num):
        for x in range(5):
            for y in range(5):
                if self.board[x][y] == int(num):
                    self.matched[x][y] = True
                    self.lastmatch = int(num)
                    return self.check_win()

    def check_win(self):
        for x in range(5):
            countrow = np.count_nonzero(self.matched[x])
            countcol = np.count_nonzero(self.matched[:,x])
            if countrow == 5 or countcol == 5:
                self.has_won = True
                return True
        return False

    def count_score(self):
        score = 0
        for x in range(5):
            for y in range(5):
                if not self.matched[x][y]:
                    score += self.board[x][y]
        return score * self.lastmatch

def solve(nums, boards):
    wins = 0
    for num in nums:
        for board in boards:
            if board.has_won:
                continue        # No need to keep checking already won ones
            win = board.check(num)

            # Wins the game
            if win:
                wins += 1
                if wins == 1: # First win
                    ans1 = board.count_score()
                if wins == len(boards): # Last board just won
                    ans2 = board.count_score()
                    return ans1, ans2
