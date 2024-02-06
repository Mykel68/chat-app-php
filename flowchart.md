# A Chat App - version 1

Flowchart for this Application.

```mermaid
flowchart
    A[register]--> B[login]
    B-->C{check if user exists?} 
    C-->|success| index
    C-->|fail| B
```