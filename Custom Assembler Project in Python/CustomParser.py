from Constants import *


###################################################
##### Token
###################################################

class Token:
    def __init__(self, type, value):
        self.type = type
        self.value = value
    
    def __repr__(self) -> str: # This is so we print a representation of the token and value 
        if self.value: 
            return f'{self.type}:{self.value}'
        return f'{self.type}'
         

##################################################
##### Lexer
##################################################

class Lexer:
    def __init__(self, text):
        self.text = text # This is going to be an array that is the characters in the text file 
        self.position = -1
        self.current_character = None # Default set to 'None'
        self.advance() # We immediately call this function to go to the first character in the file 
        
    
    def advance(self):
        self.position += 1 # Increase the "file" pointer
        if self.position < len(self.text):
            self.current_character = self.text[self.position] # Set the current character to be this
        else: 
            self.current_character = None # Set the current character to none 
    

    def token_generator(self): # This function is responsible for creating the tokens that we mentioned 

        tokens_to_store = {}

        temporaryStorage = ""
        
        while self.current_character != ' ' and self.current_character != None and self.current_character != '\n' and self.current_character != '\r':
     
            if len(temporaryStorage) > 4: raise SyntaxError # Since the highest opcode we can have is 4 characters 

            temporaryStorage += self.current_character
            self.advance() # Keep adding and advancing until we hit a space
        
        
        if temporaryStorage in token_opcode_array:

            tokens_to_store[token_type_opcode] = temporaryStorage # There can only be 1 opcode 

            currentOpcode = temporaryStorage # Save the current opcode 

            temporaryStorage = ""

            registerDiscoveredOne = False
            registerDiscoveredTwo = False 
            
            self.advance() # Go to the next character that is not a space 

            registerCount = 0
        
            while currentOpcode != "RET": # Technique to handle with opcodes other than RET 
            
                if self.current_character == ' ' or self.current_character == None:
            
                    # Check the token
                    returnToken = self.determineToken(temporaryStorage, currentOpcode, registerDiscoveredOne, registerDiscoveredTwo)
                    
                    # Check to see if this token key already exists in our dictionary

                    if returnToken.type in tokens_to_store:
                        # If the token exists 
                        tokens_to_store[returnToken.type].append(returnToken.value)
                    else:  
                        # If the token does not exist
                        tokens_to_store[returnToken.type] = []
                        tokens_to_store[returnToken.type].append(returnToken.value)

                    if returnToken.type == token_type_register:
                        registerCount += 1
                        registerDiscoveredOne = True # Set this to true 
                        if registerCount == 2:
                            registerDiscoveredTwo = True 

                    temporaryStorage = ""
                    self.advance()


                temporaryStorage += self.current_character
                self.advance()

                # If we either reach a new line or we reached EOF (in this case, we represent EOF with None)
                if self.current_character == '\n' or self.current_character == '\r' or self.current_character == None:

                    # Then we do on more token determination 
                    returnFinalToken = self.determineToken(temporaryStorage, currentOpcode, registerDiscoveredOne, registerDiscoveredTwo)
                    
                    if returnFinalToken.type in tokens_to_store:
                        # The token exists 
                        tokens_to_store[returnFinalToken.type].append(returnFinalToken.value)
                    else:
                        # The token does not exist
                        tokens_to_store[returnFinalToken.type] = []
                        tokens_to_store[returnFinalToken.type].append(returnFinalToken.value)
                    break 
            
            return tokens_to_store
        
        else: raise SyntaxError


    def determineToken(self, tokenString, currentOpcode, registerDiscoveredOne, registerDiscoveredTwo) -> Token:

        if '0x' in tokenString and (currentOpcode == "JUMP" or currentOpcode == "CALL"):  
                        
            # We not need worry about whether or not the address is out of range 
            addressToken = Token(token_type_address, int(tokenString, 16))
            return addressToken
            
            # Might need to self.advance() here but we will see later 

        elif tokenString in token_register_array:

            # We are dealing with a register 
            registerToken = Token(token_type_register, tokenString)
            registerDiscoveredOne = True 
            if (currentOpcode == "BEQ" or currentOpcode == "BNE" or currentOpcode == "BLT" or currentOpcode == "BGT") and registerDiscoveredOne == True:
                registerDiscoveredTwo = True 
            return registerToken
            # Might also need a self.advance() here 
                    
        elif tokenString.isdigit() and registerDiscoveredOne == True: 

            # We are dealing with an integer token 
            integerToken = Token(token_type_integer, int(tokenString))
            return integerToken
            # Might also need a self.advance() here 
        
        elif '0x' in tokenString and registerDiscoveredOne == True and registerDiscoveredTwo == True: # Need to ensure both registers

            # We are dealing with a BEQ or BNE 
            addressToken = Token(token_type_address, int(tokenString, 16)) # Encode in hexadecimal 
            return addressToken
        
        # Error is raised if there is another opcode that is provided 
        else: raise SyntaxError 

#########################################################
##### Parser 
#########################################################

class Parser:
    def __init__(self, tokens):
        self.tokens = tokens

    def opcodeManagement(self):

        # Remember: Our instructions are about 3 bytes long so we need to take that into consideration 
        binaryStringRepresentationOfInstruction = "" 

        # Get the opcode 
        getOpcode = self.tokens[token_type_opcode]

        # Get the hexadecimal value of the opcode and the list of rules for the designated opcode 
        hexOpcode = int(token_opcode_hex[getOpcode], 16)

        # Enforce the opcode to be 1 byte
        hexOpcode = format(hexOpcode, '08b')

        binaryStringRepresentationOfInstruction += hexOpcode

        # Set up the list of rules to iterate over         
        opcodeRuleList = token_dictionary_and_rules[getOpcode]

        # We will create an argument enforcement dictionary to ensure the right number of arguments has been passed by the user
        argument_enforcer_dictionary = {}

        # For each rule we need to iterate over 
        for rule in opcodeRuleList:

            # If the rule is in the dictionary, then we perform parsing 
            if rule in self.tokens: 

                # Then we grab the list 
                specific_token_list = self.tokens[rule]

                if len(specific_token_list) == 0:
                    # An error, as there is no register found 
                    raise SyntaxError 
                else:
                    # We extract the first value from the list and shift elements to the left 
                    firstValue = specific_token_list.pop(0) 
    
                    argument_enforcer_dictionary[rule] = len(specific_token_list)
                
                # Get the hexadecimal value of the item, if the rule is a register
                if rule == token_type_register:

                    hexRegister = int(token_register_hex[firstValue], 16)
                    
                    # Enforce 1 byte rule 
                    hexRegister = format(hexRegister, '08b')

                    binaryStringRepresentationOfInstruction += hexRegister
                
                # Any other value, such as Immediate or Address 
                else:

                    if getOpcode == "JUMP" or getOpcode == "CALL":

                        hexRepresentation = firstValue

                        # Enforce 2 byte rule 
                        hexRepresentation = format(hexRepresentation, '016b')

                        binaryStringRepresentationOfInstruction += hexRepresentation
                                
                    elif getOpcode == "LD":

                        hexRepresentation = firstValue

                        # Enforce 1 byte rule 
                        hexRepresentation = format(hexRepresentation, '08b')

                        binaryStringRepresentationOfInstruction += hexRepresentation
            
            else: raise SyntaxError # This is considered to be an error 
        
        for values in argument_enforcer_dictionary.values():
            
            # We raise a syntax error if none of the values are equal to 0 
            if values != 0: raise SyntaxError


        # We will come back later to do more error handling 
        if getOpcode != "JUMP" and getOpcode != "LD" and getOpcode != "CALL" and getOpcode != "RET":
            
            remainingByte = 0

            remainingByte = format(remainingByte, '08b')

            binaryStringRepresentationOfInstruction += remainingByte
        
        elif getOpcode == "RET":

            remainingByte = 0
            
            # Enforce the 2 byte rule 
            remainingByte = format(remainingByte, '016b')

            binaryStringRepresentationOfInstruction += remainingByte
        
        # Justify that our final string is of length of 4 bytes 

        binaryStringRepresentationOfInstruction = binaryStringRepresentationOfInstruction = binaryStringRepresentationOfInstruction[:24].ljust(24, '0')

        return binaryStringRepresentationOfInstruction


def runParser(text):

    # We first create a lexer 
    customLexer = Lexer(text) # Create a Lexer instance 
    tokens = customLexer.token_generator() # Begin listening and generating tokens 

    # Now we handle the tokens by making the parser 
    customParser = Parser(tokens)
    binaryRepOfInstructions = customParser.opcodeManagement()

    return binaryRepOfInstructions 
 