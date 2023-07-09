import CustomParser
import Emulator
import sys

# We have an input file that has statements of our custom language 

# For now, we want each line in the output file to print out the tokens 
original_stdout = sys.stdout

with open('input\\input.txt', 'r') as input_file:

    with open('output\\output.txt', 'w') as output_file:

        for lineOfText in input_file:

            tokenResult = CustomParser.runParser(lineOfText)

            sys.stdout = output_file

            print(tokenResult) # By default, a new line is printed out 

with open('output\\output.txt', 'r') as file:

    sys.stdout = original_stdout

    emulator = Emulator.runEmulator('output\\output.txt') # Send in the name of the file 