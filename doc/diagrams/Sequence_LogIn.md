```mermaid
    sequenceDiagram
        participant U as <<Actor>><br/>User
        participant T as <<Interface>><br/>Front-End / Twig
        participant S as <<Interface>><br/>Symfony
        participant D as <<Interface>><br/>Database / Doctrine
        U ->> T: Click on the "Log In" link
        activate U
        activate T
        T -->> S: Receives Request
        activate S
        S -->> T: Sends Response
        T -->> U: Renders the form
        U ->> T: Enters credentials
        U ->> T: Submits form
        T -->> S: Receives Request
        S -->> D: Checks Data
        activate D
        D -->> S: Sends Data
        deactivate D
        S -->> S: Saves User's connection
        S -->> T: Sends Response
        deactivate S
        T -->> U: Redirects to homepage
        deactivate T
        deactivate U
```