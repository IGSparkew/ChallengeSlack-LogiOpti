import React, { useState } from 'react';

const AddUserForm = ({ onAddUser }) => {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [surname, setSurname] = useState('');
    const [password, setPassword] = useState('');
    const [salaire, setSalaire] = useState('');
    const [vehicule, setVehicule] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        onAddUser({ name, email, surname, password, salaire, vehicule });
        setName('');
        setEmail('');
        setSurname('');
        setPassword('');
        setSalaire('');
        setVehicule('');
    };

    return (
        <div className=" bg-gray-100 p-4">
            <div className="flex justify-between p-4">
                <button className="bg-blue-500 text-white p-2 rounded">Trajet</button>
                <h2 className="text-xl font-semibold">Welcome Back, Clint</h2>
            </div>
            <div className="p-4">
                <div className="w-full mx-auto p-4 border rounded-lg bg-white overflow-y-auto">
                    <form onSubmit={handleSubmit} className="mb-4">
                        <div className="flex flex-wrap -mx-2">
                            {/* NOM */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="name" className="block text-sm font-medium">Nom :</label>
                                <input type="text" id="name" value={name} onChange={(e) => setName(e.target.value)} className="border p-2 w-full" />
                            </div>
                            {/* EMAIL */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="email" className="block text-sm font-medium">Email :</label>
                                <input type="email" id="email" value={email} onChange={(e) => setEmail(e.target.value)} className="border p-2 w-full" />
                            </div>
                            {/* PRENOM */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="surname" className="block text-sm font-medium">Prénom :</label>
                                <input type="text" id="surname" value={surname} onChange={(e) => setSurname(e.target.value)} className="border p-2 w-full" />
                            </div>
                            {/* PASSWORD */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="password" className="block text-sm font-medium">Mot de passe :</label>
                                <input type="text" id="password" value={password} onChange={(e) => setPassword(e.target.value)} className="border p-2 w-full" />
                            </div>
                            {/* SALAIRE */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="salaire" className="block text-sm font-medium">Salaire :</label>
                                <input type="text" id="salaire" value={salaire} onChange={(e) => setSalaire(e.target.value)} className="border p-2 w-full" />
                            </div>
                            {/* VEHICULE */}
                            <div className="mb-2 px-2 w-1/2">
                                <label htmlFor="vehicule" className="block text-sm font-medium">Véhicule :</label>
                                <input type="text" id="vehicule" value={vehicule} onChange={(e) => setVehicule(e.target.value)} className="border p-2 w-full" />
                            </div>
                        </div>
                        <button type="submit" className="bg-blue-500 text-white p-2 rounded">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default AddUserForm;
