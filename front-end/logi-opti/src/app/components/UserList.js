// components/UserList.js
import React from 'react';

const UserList = ({ users, onEditUser, onDeleteUser }) => {
    return (
        <div>
            {users.map(user => (
                <div key={user.id} className="border p-4 mb-2">
                    <h2 className="text-xl font-semibold">{user.name}</h2>
                    <p>Email: {user.email}</p>
                    <button onClick={() => onEditUser(user)} className="mr-2">Edit</button>
                    <button onClick={() => onDeleteUser(user.id)}>Delete</button>
                </div>
            ))}
        </div>
    );
};

export default UserList;
