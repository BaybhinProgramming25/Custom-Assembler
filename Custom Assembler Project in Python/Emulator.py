# Where we are going to define our emulator to run our binary instructions
# We define the start and end address of our memory 

import numpy as np 

# We first define the space that is used for ROM (aka where we are going to store our instructions)
# Since we want to have about 8192 bytes of memory, our address will range from 0x0000 to 0x1FFF

start_address = 0x000000
end_address = 0x0007FF 

class CustomEmulator:

    def __init__(self):
    # Define our memory
        self.memory = np.zeros(8192, dtype=np.uint32)

        # Define our 14 general purpose registers, and our 2 special registers being the programCounter and stackPointer 
        self.registers = np.zeros(14, dtype=np.uint8)
        self.programCounter = np.uint16(0)
        self.stackPointer = np.uint8(0)

        # Define our stack and instruction (i.e. what instruction is currently being done)
        self.stack = np.zeros(16, dtype=np.uint16)
        self.instruction = 0

        # We also want the instruction size to see how many times we need to cycle through the emulator
        self.instruction_size = 0


    # We first want to define the method that will load the ROM 
    def loadROM(self, fileName):
        
        # We need to read a ROM file that has the set of instructions
        with open(fileName, 'r') as file:
            i = 0
            for line in file:
                
                # Convert the string into a binary representation 
                line = int(line, 2)

                self.memory[start_address + i] = line
                self.instruction_size += 1
                i += 1


    # We also want to initalize our program counter
    def initializeProgramCounter(self):

        # This is just going to be equal to our start address 
        self.programCounter = start_address
    
    # Now we are going to need methods for every one of the opcodes 
    
    # Opcode = 1 byte, Register = 1 byte, Data = 1 bytes 
    def opcode_ld(self):
        
        register = (self.instruction & 0x00FF00) >> 8
        immediate = (self.instruction & 0x0000FF) 

        register = np.uint8(register)
        immediate = np.uint16(immediate)

        self.registers[register] = immediate
    
    # Opcode = 1 byte, Register1 = 1 byte, Register2 = 1 byte
    def opcode_mv(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF) 

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] = self.registers[register_two]
    
    def opcode_add(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF) 

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] += self.registers[register_two]
    
    def opcode_sub(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF) 

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] -= self.registers[register_two]
    
    def opcode_mult(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF) 

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] *= self.registers[register_two]
    
    def opcode_div(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] /= self.registers[register_two]
    
    def opcode_or(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] = (self.registers[register_one] | self.registers[register_two])
    
    def opcode_and(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] = (self.registers[register_one] & self.registers[register_two])
    
    def opcode_mod(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        # In this version, we are going to store the modulus value in the register 
        self.registers[register_one] = (self.registers[register_one] % self.registers[register_two])

    # Opcode = 1 byte, Address = 2 bytes 
    def opcode_jump(self):

        # We essentially jump to the address by making the program counter equal to the address 

        address = (self.instruction & 0x00FFFF) 

        address = np.uint16(address)

        self.programCounter = address

    def opcode_sra(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] = (self.registers[register_one] >> self.registers[register_two])
    
    def opcode_sla(self):

        register_one = (self.instruction & 0x00FF00) >> 8
        register_two = (self.instruction & 0x0000FF)

        register_one = np.uint8(register_one)
        register_two = np.uint8(register_two)

        self.registers[register_one] = (self.registers[register_one] >> self.registers[register_two])

    # This opcode will make the CPU start execution on the stack 
    def opcode_call(self):

        address = (self.instruction & 0x00FFFF)

        address = np.uint16(address)

        self.stack[self.stackPointer] = self.programCounter
        self.stackPointer += 1

        self.programCounter = address 
    
    # This opcode resumes execution back to where the address originally was 
    def opcode_ret(self):

        # We first decrease the stack pointer then set the program counter to the address 
        self.stackPointer -= 1

        self.programCounter = self.stack[self.stackPointer]
        
    # A custom method that will print all the registers
    def printRegisters(self):
        
        # We simply print the 14 registers and their values 
        for index in range(len(self.registers)):

            print(f'This is the value of R{index+1} register: {self.registers[index]}')

    
    # We are going to need a separate method to cycle through the list of instructions that we have
    def cycleThroughInstructions(self):
        self.instruction = self.memory[self.programCounter]

        # Then we extract the first 8 bits and shift those 8 bits 24 bits to the right
        opcodeValue = (self.instruction & 0xFF0000) >> 16

        if opcodeValue == 0:
            self.opcode_ld()
        elif opcodeValue == 1:
            self.opcode_mv()
        elif opcodeValue == 2:
            self.opcode_add()
        elif opcodeValue == 3:
            self.opcode_sub()
        elif opcodeValue == 4:
            self.opcode_mult()
        elif opcodeValue == 5:
            self.opcode_div()
        elif opcodeValue == 6:
            self.opcode_or()
        elif opcodeValue == 7:
            self.opcode_and()
        elif opcodeValue == 8:
            self.opcode_mod()
        elif opcodeValue == 9:
            self.opcode_jump()
        elif opcodeValue == 10:
            self.opcode_sra()
        elif opcodeValue == 11:
            self.opcode_sla()
        elif opcodeValue == 12:
            self.opcode_call()
        elif opcodeValue == 13:
            self.opcode_ret()
        else: raise SyntaxError

        # After doing an instruction, we then need to increase the program counter 
        # For this implementation, we will increase the program counter by 1 
        self.programCounter += 1

    
    # Then our last important method is to create the emulation cycle
    def emulateCustomLanguage(self):
        for i in range(self.instruction_size):
            self.cycleThroughInstructions()


def runEmulator(fileName):

    emulator = CustomEmulator()

    emulator.loadROM(fileName)

    emulator.initializeProgramCounter()

    emulator.emulateCustomLanguage()

    emulator.printRegisters()
