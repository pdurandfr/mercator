## Niveaux de maturité

Ce chapitre détaille le calcul des niveaux de maturité des objets de la cartographie.

### Pourcentage de conformité

Le pourcentage de conformité représente l'effort qu'il reste à réaliser pour être conforme.
Ce pourcentage est calculé en divisante le nombre d'éléments conformes par le nombre total d'élements.

### Règles de calcul

Un objet est conforme si toutes les informations sur l'objet ont été fournies.
S'il manque des informations, l'objet est non-conforme.

Cela peut être l'absence d'un attribut : une application sans description, l'absence d'un point de contact pour une entité, 
la criticité qui n'est pas spécifiés... ou l'absence d'une relation avec d'autres objets : un serveur sans applications, un processus sans acteurs, 
une application qui ne sert aucun processus...

Les règles appliquées à ce calcul sont les suivantes :

* Un élément peut être conforme au niveau n, et ne pas être conforme au niveau n+1. L'inverse n'est pas vrais.

* S'il 'y a pas de nouveaux attributs qui entre en compte pour passer du niveau n au niveau n+1, l'objet conforme au niveau n reste conforme au niveau n+1.

### Exigences de conformité


| Objet | Niveau | Exigences |
|---    |:-:     |---              |
| **Écosystème** | | |
| Entités | 1 | doit avoir une description, un niveau de sécurité, un point de contact et supporter au moins un processus |
| Relations | 1 | doit avoir un type et une description |
| Relations | 2 | doit avoir une importance |
| **Système d'Information** | | |
| Macro-Processus | 2 | doit avoir une description, des éléments d'entrée/sortie et un besoins de sécurité (CIDT) |
| Macro-Processus | 3 | doit avoir un propriétaire |
| Processus | 1 | doit avoir une description, des éléments d'entrée/sortie, un propriétaire  |
| Processus | 2 | doit avoir un niveau de sécurité et faire partie d'un macro-processus |


