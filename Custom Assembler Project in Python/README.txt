This is a Custom Assembler made in Python that handles a small set of instructions. 

The custom assembler is a 32-bit architecture, with 14 general purpose registers and 2 special purpose registers (i.e. R1, R2, R3, ... R14) and (PC, SP)

Each instruction is going to be 3 bytes (24 bits) long, as these instructions are going to be stored in MSB format.

14 different opcodes are supported for this architecture, which are the following:

LD: Load Instruction (Ex: LD R1 Immediate)
MV: Move Instruction (Ex: MV R1 R2)
ADD: Addition Instruction (Ex: ADD R1 R2) 
SUB: Subtraction Instruction (Ex: SUB R1 R2)
MULT: Multiplication Instruction (Ex: MULT R1 R2)
DIV: Division Instruction (Ex: DIV R1 R2)
OR: Bitwise OR Instruction (Ex: OR R1 R2)
AND: Bitwise AND Instruction (Ex: AND R1 R2)
MOD: Modulus Instruction (Ex: MOD R1 R2)
JUMP: Jump Instruction (Ex: JUMP Address) 
SRA: Shift Right Arithmetic Instruction (Ex: SRA R1 R2)
SLA: Shift Left Arithmetic Instruction (Ex: SLA R1 R2)
CALL: Call Instruction (Ex: CALL Address)
RET: Return Instruction (Ex: RET) 

How to run the program:

1) Go to the input folder. This is where you can type out which of the 14 instructions you want to run per line

2) Once typed in the input folder, run the program in Main.py

3) Assuming there is no SyntaxError produced, the console will display the values of the 14 registers in order to verify the instructions have run correctly. The output folder displays the binary form of the instructions in each line. 
