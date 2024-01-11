import React from 'react';
import { BsPersonFill, BsThreeDotsVertical, BsTruck } from 'react-icons/bs';
import { data } from '../data/data';

const table = () => {
    return (
        <div className='  min-h-screen'>
            <div className='flex justify-between p-4'>
                <button className='bs'>Action</button>
                <button type="button" class="mr-9  bg-blue-500 hover:bg-blue-700 text-white py-4 px-2 p-1r rounded focus:outline-none focus:shadow-outline">Ajouter</button>
            </div>
            <div className='p-4'>
                <div className='w-full m-auto p-4 border rounded-lg bg-white overflow-y-auto'>
                    <div className='my-3 p-2 grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 items-center justify-between cursor-pointer'>
                        <span>Name</span>
                        <span className='sm:text-left text-right'>Email</span>
                        <span className='hidden md:grid'>Last Order</span>
                        <span className='hidden sm:grid'>Action</span>
                    </div>
                    <ul>
                        {data.map((order, id) => (
                            <li key={id} className='bg-red-50 hover:bg-gray-100 rounded-lg my-3 p-2 grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 items-center justify-between cursor-pointer'>
                                <div className='flex items-center'>
                                    <div className='bg-purple-100 p-3 rounded-lg'>
                                        <BsTruck className='text-purple-800' />
                                    </div>
                                    <p className='pl-4'>{order.name.first + ' ' + order.name.last}</p>
                                </div>
                                <p className='text-gray-600 sm:text-left text-right'>{order.name.first}@gmail.com</p>
                                <p className='hidden md:flex'>{order.date}</p>
                                <div className='sm:flex hidden justify-between items-center'>
                                    <button className="bg-green-300">Modifier</button>
                                    <button className="bg-red-300">Supprimer</button>
                                    <BsThreeDotsVertical />
                                </div>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default table;