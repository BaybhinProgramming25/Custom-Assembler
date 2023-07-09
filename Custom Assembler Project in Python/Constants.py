token_opcode_array = ['LD', 'MV', 'ADD', 'SUB', 'MULT', 'DIV', 'OR', 'AND', 'MOD', 'JUMP', 'SRA', 'SLA', 'CALL', 'RET']

# 16 registers (R1 to R14 general purpose registers, 2 special purpose registers)
token_register_array = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'R9', 'R10', 'R11', 'R12', 'R13', 'R14', 'PC', 'SP']

# Define digit constants 
digits = "0123456789"

# The 4 main types of tokens 
token_type_opcode = 'OPCODE'
token_type_register = 'REGISTER'
token_type_integer = 'INTEGER'
token_type_address = 'ADDRESS'

# Give each opcode a hexadecimal encoding
token_opcode_hex = {

    "LD": hex(0)[2:],
    "MV": hex(1)[2:],
    "ADD": hex(2)[2:],
    "SUB": hex(3)[2:],
    "MULT": hex(4)[2:],
    "DIV": hex(5)[2:],
    "OR": hex(6)[2:],
    "AND": hex(7)[2:],
    "MOD": hex(8)[2:],
    "JUMP": hex(9)[2:],
    "SRA": hex(10)[2:],
    "SLA": hex(11)[2:],
    "CALL": hex(12)[2:],
    "RET": hex(13)[2:],
}

# We also give each register a hexadecimal encoding 
token_register_hex = {

    "R1": hex(0)[2:],
    "R2": hex(1)[2:],
    "R3": hex(2)[2:],
    "R4": hex(3)[2:],
    "R5": hex(4)[2:],
    "R6": hex(5)[2:],
    "R7": hex(6)[2:],
    "R8": hex(7)[2:],
    "R9": hex(8)[2:],
    "R10": hex(9)[2:],
    "R11": hex(10)[2:],
    "R12": hex(11)[2:],
    "R13": hex(12)[2:],
    "R14": hex(13)[2:],
    "PC": hex(14)[2:],
    "SP": hex(15)[2:]
}

# Defines the rules of each opcode 
token_dictionary_and_rules = {

    "LD": [token_type_register, token_type_integer],
    "MV": [token_type_register, token_type_register],
    "ADD": [token_type_register, token_type_register],
    "SUB": [token_type_register, token_type_register],
    "MULT": [token_type_register, token_type_register],
    "DIV": [token_type_register, token_type_register],
    "OR": [token_type_register, token_type_register],
    "AND": [token_type_register, token_type_register],
    "MOD": [token_type_register, token_type_register],
    "JUMP": [token_type_address],
    "SRA": [token_type_register, token_type_register],
    "SLA": [token_type_register, token_type_register],
    "CALL": [token_type_address],
    "RET": [],
}


