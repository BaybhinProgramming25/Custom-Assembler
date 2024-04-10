# Custom Assembler 

This is a custom assembler made with Python. The assembler follows a 32-bit architecture and has 14 general purpose registers, and 2 special purpose registers. Each instruction is about 3 bytes long and are stored in Most Significant Bit (MSB) format 

# Instructions

The architecture has 14 different opcodes, which are the following: 

- LD: Load Instruction (Ex: LD R1 Immediate)
- MV: Move Instruction (Ex: MV R1 R2)
- ADD: Addition Instruction (Ex: ADD R1 R2) 
- SUB: Subtraction Instruction (Ex: SUB R1 R2)
- MULT: Multiplication Instruction (Ex: MULT R1 R2)
- DIV: Division Instruction (Ex: DIV R1 R2)
- OR: Bitwise OR Instruction (Ex: OR R1 R2)
- AND: Bitwise AND Instruction (Ex: AND R1 R2)
- MOD: Modulus Instruction (Ex: MOD R1 R2)
- JUMP: Jump Instruction (Ex: JUMP Address) 
- SRA: Shift Right Arithmetic Instruction (Ex: SRA R1 R2)
- SLA: Shift Left Arithmetic Instruction (Ex: SLA R1 R2)
- CALL: Call Instruction (Ex: CALL Address)
- RET: Return Instruction (Ex: RET) 

# Running The Program

1) Go to the input folder. This is where you can type out which of the 14 instructions you want to run per line
2) Once typed in the input folder, run the program in Main.py
3) The console will display the values of the 14 registers in order to verify the instructions have run correctly. The output folder displays the binary form of the instructions in each line. 
