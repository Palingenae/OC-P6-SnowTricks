```mermaid
    %%{init: {'theme': 'base', 'themeVariables': { 'primaryColor': '#93C6F0', 'primaryTextColor': '#2F243A', 'fontFamily': 'consolas'}}}%%
    classDiagram
        class ClassDiagram {
            BuildWith MermaidJS
        }
        Trick "1" --> "0..n" TrickGroup: belongs to
        Trick "1" --> "0..n" Image: has
        Trick "1" --> "0..n" Video: has
        Trick "1" --> "0..n" Message: has
        User "1" --> "0..n" Trick: creates
        User "1" --> "0..n" Message: writes
        class Trick {
            -string $name
            -string $description
            -string $slug
            -Image $coverImage
            -Collection<Image> $image
            -Collection<Video> $video
        }
        class User {
            -string $firstname
            -string $lastname
            -string $username
            -string $emailAddress
            -string $password
            -Image $profileImage
            -string $token
        }
        class Message {
            -User $user
            -Trick $trick
            -string $content
            -DateTime $createdAt
        }
        class TrickGroup {
            -string $name
            -Collection<Trick> $tricks
        }
        class Image {
            -string $fileName
            -string $filePath
            -string $description
        }
        class Video {
            -string $name
            -string $url
        }
```
