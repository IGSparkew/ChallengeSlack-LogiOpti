// lib/userService.js

// Simuler une base de données en mémoire
let users = [
    { id: 1, name: 'Alice', surname: 'bouvier', password: '***********', salaire: '1234€', vehicule: 'scania 2VT', email: 'alice@example.com' },
    { id: 2, name: 'Bob', surname: 'marc', password: '***********', salaire: '1234€', vehicule: 'scania 2VT', email: 'bob@example.com' },
    { id: 3, name: 'Charlie', surname: 'hames', password: '***********', salaire: '1234€', vehicule: 'scania 2VT', email: 'charlie@example.com' }
];

// Fonction pour générer un nouvel ID
const generateId = () => {
    return users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1;
};

// Récupérer tous les utilisateurs
export const fetchUsers = async () => {
    // Retourner une copie pour éviter les modifications directes
    return Promise.resolve([...users]);
};

// Ajouter un utilisateur
export const addUser = async (user) => {
    const newUser = { ...user, id: generateId() };
    users.push(newUser);
    return Promise.resolve(newUser);
};

// Mettre à jour un utilisateur
export const updateUser = async (updatedUser) => {
    users = users.map(user => user.id === updatedUser.id ? updatedUser : user);
    return Promise.resolve(updatedUser);
};

// Supprimer un utilisateur
export const deleteUser = async (userId) => {
    users = users.filter(user => user.id !== userId);
    return Promise.resolve();
};
