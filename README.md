### Objective

Jackpot! You've landed a summer gig in Las Vegas! Unfortunately, it's 2021, and the casinos are closed due to COVID-19. Your boss wants to move some of the business online and asks you to build a full-stack app — a simple slot machine game, with a little twist. Build it to ensure that the house always wins!

### Brief

When a player starts a game/session, they are allocated 10 credits. 
Pulling the machine lever (rolling the slots) costs 1 credit. 
The game screen has 1 row with 3 blocks. 
For players to win the roll, they have to get the same symbol in each block.
There are 4 possible symbols: cherry (10 credits reward), lemon (20 credits reward), orange (30 credits reward), and watermelon (40 credits reward).
The game (session) state has to be kept on the server.
If the player keeps winning, they can play forever, but the house has something to say about that...
There is a CASH OUT button on the screen, but there's a twist there as well.

### Tasks

- Implement assignment using:
    - Language: *PHP*
    - Framework: *Laravel*
- When a user opens the app, a session is created on the server, and they have 10 starting credits.
- **Server-side:**
    - When a user has less than 40 credits in the game session, their rolls are truly random.
    - If a user has between 40 and 60 credits, then the server begins to slightly cheat:
        - For each winning roll, before communicating back to the client, the server does one 30% chance roll which decides if the server will re-roll that round.
        - If that roll is true, then the server re-rolls and communicates the new result back.
    - If the user has above 60 credits, the server acts the same, but in this case the chance of re-rolling the round increases to 60%.
        - If that roll is true, then the server re-rolls and communicates the new result back.
    - There is a cash-out endpoint that moves credits from the game session to the user's account and closes the session.

- **Client side:**
    - Include a super simple, minimalistic table with 3 blocks in 1 row.
    - Include a button next to the table that starts the game.
    - The components for each sign can be a starting letter (C for cherry, L for lemon, O for orange, W for watermelon).
    - After submitting a roll request to the server, all blocks should enter a spinning state (can be the character 'X' spinning).
    - After receiving a response from the server, the first sign should spin for 1 second more and then display the result, then display the second sign at 2 seconds, then the third sign at 3 seconds.
    - If the user wins the round, their session credit is increased by the amount from the server response, else it is deducted by 1.
    - Include a button on the screen that says "CASH OUT", but when the user hovers it, there is a 50% chance that the button moves in a random direction by 300px, and a 40% chance that it becomes unclickable (this roll should be done on the client-side). If they succeed to hit it, credits from the session are moved to their account.
- Write tests for your business logic

### Evaluation Criteria

- *PHP* best practices
- Completeness: did you complete the features as briefed?
- Correctness: does the solution perform in sensible, thought-out ways?
- Maintainability: is the code written in a clean, maintainable way?
- Testing: was the system adequately tested?

### CodeSubmit

Please organize, design, test and document your code as if it were going into production - then push your changes to the master branch. After you have pushed your code, you may submit the assignment on the assignment page.

All the best and happy coding,

The Housr Team

** The remaining part of the README has been added by myself (Martin Shaw) **

### Video of the result

You can see a video of the result [here](./Final%20Cut%20Raw.mp4)