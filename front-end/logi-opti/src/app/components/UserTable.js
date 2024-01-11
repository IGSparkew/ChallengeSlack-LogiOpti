import React from 'react';
import { BsPersonFill } from 'react-icons/bs';

const UserTable = ({ users, onEditUser, onDeleteUser }) => {
    return (
        <div className="bg-gray-100 p-4">
            <table className="w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr className="sm:text-left text-center">
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Mot de passe</th>
                        <th>Salaire</th>
                        <th>Véhicule</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map((user) => (
                        <tr key={user.id} className="bg-gray-50 hover:bg-gray-100 my-3 p-2 items-center justify-between cursor-pointer">
                            <td className="flex items-center">
                                <div className="bg-purple-100 p-3 rounded-lg">
                                    <BsPersonFill className="text-purple-800" />
                                </div>
                                {user.id}
                            </td>
                            <td>{user.name}</td>
                            <td>{user.surname}</td>
                            <td>{user.password}</td>
                            <td>{user.salaire}</td>
                            <td>{user.vehicule}</td>
                            <td>{user.email}</td>
                            <td>
                                <button onClick={() => onEditUser(user)} className="bg-green-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2">
                                    Éditer
                                </button>
                                <button onClick={() => onDeleteUser(user.id)} className="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default UserTable;
