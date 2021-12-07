import numpy as np

def main(inputsrt):
    nums, boardstrs = inputsrt.split("\n",1)
    nums = [int(i) for i in nums.split(",")]
    boardstrs = boardstrs.strip().split("\n\n")
    boards = []
    for b in boardstrs:
        boards.append(Board(b))
    ans1, ans2 = solve(nums, boards)
    return ans1,ans2

class Board:
    def __init__(self,boardstr):
        # Separate all the numbers from the list
        nums = [int(i) for b in boardstr.split("\n") for i in b.strip(" ").replace("  "," ").split(" ")]
        self.board = np.array(nums).reshape([5,5])  # Reshape the board to what it needs to be
        self.matched = np.zeros((5,5),np.bool)      # Table to know which positions were already matched
        self.lastmatch = 0                          # Last matched number. Needed for counting score
        self.has_won = False

    # Check if the number is on board and mark it. Return True if this wins the game
    def check(self,num):
        match = self.board == num
        self.matched = self.matched | match
        if match.any():
            self.lastmatch = num
            self.check_win()

    def check_win(self):
        for x in range(5):
            countrow = np.count_nonzero(self.matched[x])
            countcol = np.count_nonzero(self.matched[:,x])
            if countrow == 5 or countcol == 5:
                self.has_won = True

    def count_score(self):
        score = 0
        score = np.sum(self.board[self.matched != True])
        return score * self.lastmatch

def solve(nums, boards):
    wins = 0
    for num in nums:
        for board in boards:
            if board.has_won:
                continue        # No need to keep checking already won ones
            board.check(num)

            # Wins the game
            if board.has_won:
                wins += 1
                if wins == 1: # First win
                    ans1 = board.count_score()
                if wins == len(boards): # Last board just won
                    ans2 = board.count_score()
                    return ans1, ans2
