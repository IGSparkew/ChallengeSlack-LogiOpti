'use client'
import React, { useState, useEffect } from 'react';
import UserTable from '@/app/components/UserTable';
import { fetchUsers, addUser, updateUser, deleteUser } from '@/app/lib/userService';

const HomePage = () => {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        const loadUsers = async () => {
            const fetchedUsers = await fetchUsers();
            setUsers(fetchedUsers);
        };

        loadUsers();
    }, []);

    const handleAddUser = async (user) => {
        const newUser = await addUser(user);
        setUsers([...users, newUser]);
    };

    const handleEditUser = async (user) => {
        const updatedUser = await updateUser(user);
        setUsers(users.map(u => u.id === updatedUser.id ? updatedUser : u));
    };

    const handleDeleteUser = async (userId) => {
        await deleteUser(userId);
        setUsers(users.filter(u => u.id !== userId));
    };

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-xl font-bold mb-4">Gestion des Utilisateurs</h1>
            <UserTable
                users={users}
                onAdd={handleAddUser}
                onEdit={handleEditUser}
                onDelete={handleDeleteUser}
            />
        </div>
    );
};

export default HomePage;
