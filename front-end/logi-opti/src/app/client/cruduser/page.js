'use client'

import React, { useState, useEffect } from 'react';
import UserTable from '@/app/components/UserTable';
import UserList from '@/app/components/UserList';
import AddUserForm from '@/app/components/AddUserForm';
import EditUserForm from '@/app/components/EditUserForm';
import { fetchUsers, addUser, updateUser, deleteUser } from '@/app/lib/userService';
import Sidebar from '@/app/components/Sidebar';

const HomePage = () => {
    const [users, setUsers] = useState([]);
    const [editingUser, setEditingUser] = useState(null);

    useEffect(() => {
        const loadData = async () => {
            const fetchedUsers = await fetchUsers();
            setUsers(fetchedUsers);
        };

        loadData();
    }, []);

    const handleAddUser = async (user) => {
        const newUser = await addUser(user);
        setUsers([...users, newUser]);
    };

    const handleUpdateUser = async (user) => {
        const updatedUser = await updateUser(user);
        setUsers(users.map(u => u.id === updatedUser.id ? updatedUser : u));
        setEditingUser(null);
    };

    const handleDeleteUser = async (userId) => {
        await deleteUser(userId);
        setUsers(users.filter(u => u.id !== userId));
    };

    return (
        <>


            <div className="  flex-auto bg-gray-200">
                <h1 className="text-2xl font-bold my-4">Liste des Utilisateurs</h1>
                {editingUser ? (
                    <EditUserForm user={editingUser} onUpdateUser={handleUpdateUser} onCancel={() => setEditingUser(null)} />
                ) : (
                    <AddUserForm onAddUser={handleAddUser} />
                )}
                <UserTable users={users} onEditUser={setEditingUser} onDeleteUser={handleDeleteUser} />
            </div>
        </>

    );
};


export default HomePage;
