
def main(inputstr):
    binary = bin(int('1'+inputstr,16))[3:]
    ans1 = part1(binary)
    ans2 = part2(binary)
    return ans1, ans2

class Module:
    def __init__(self, b : list, offset : int):
        self.version = int(b[offset:offset+3], 2)
        self.type = int(b[offset+3:offset+6], 2)
        self.start = offset

        # Literal value
        if self.type == 4:
            ind = offset + 6
            val = ""
            while b[ind] == '1':
                val += b[ind+1:ind+5]
                ind += 5
            val += b[ind+1:ind+5]
            self.value = int(val,2)
            self.end = ind+5            # The bit that no longer belongs to this module
        
        # Operator
        else:
            lenbit = int(b[offset+6],2)
            self.childs = []

            # Bits of sub packets
            if lenbit == 0:
                sublen = offset + 22 + int(b[offset+7: offset+22],2)
                nextind = offset + 22
                while nextind < sublen:
                    child = Module(b,nextind)
                    self.childs.append(child)
                    nextind = child.end

            # Number of sub packets
            else:
                sublen = int(b[offset+7:offset+18],2)
                nextind = offset+18
                for c in range(sublen):
                    child = Module(b,nextind)
                    self.childs.append(child)
                    nextind = child.end
            self.end = nextind

            values = [c.value for c in self.childs]
            # SUM
            if self.type == 0:
                self.value = sum(values)
            
            # PRODUCT
            elif self.type == 1:
                self.value = values[0]
                for i in range(1,len(values)):
                    self.value = self.value * values[i]

            # MINIMUM
            elif self.type == 2:
                self.value = min(values)

            # MAXIMUM
            elif self.type == 3:
                self.value = max(values)

            # GREATER THAN
            elif self.type == 5:
                self.value = int(values[0] > values[1])

            # LESS THAN
            elif self.type == 6:
                self.value = int(values[0] < values[1])

            # EQUAL TO
            elif self.type == 7:
                self.value = int(values[0] == values[1])

        return

    # Needed for part1
    def count_version_sum(self):
        sum = self.version
        if self.type != 4:
            for child in self.childs:
                sum += child.count_version_sum()
        return sum

def part1(b):
    sum = 0
    nextind = 0
    while nextind + 11 < len(b):    # 11 is the minimum number of bits in a module
        mod = Module(b,nextind)     #...(and this way we automatically ignore the trailing padding zeros)
        sum += mod.count_version_sum()
        nextind = mod.end
    return sum


def part2(b):
    mod = Module(b,0)
    return mod.value
    