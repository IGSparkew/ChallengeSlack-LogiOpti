'use client'
import React, { useState,useEffect } from 'react';
import { BsPersonFill, BsThreeDotsVertical, BsTruck } from 'react-icons/bs';
import { data } from '../data/data1';

const table = ({data, setSelectedMoyen,setSelectedTemps,selectedTemps}) => {
    
    const [selectedTab, setSelectedTab] = useState("trajet");

    const changeColorBg = (tab) => {
        console.log("tab :",tab)


        console.log(selectedTemps);
        setSelectedTab(tab);
        setSelectedMoyen(tab);

        if(tab == "trajet"){
            setSelectedTemps("day");
        }

        if(tab == "camion"){
            setSelectedTemps("dayCamion");
        }

    };

    return (
        <div className='  min-h-screen flex flex-col '>
            <div className='flex justify-around p-4 w-6/12 self-center mt-20'>
                <button onClick={() => changeColorBg("trajet")} className={`${selectedTab === "trajet" ? "bg-redFull text-white" : "bg-redFullClair2 text-redFull cursor-pointer"} bs  px-10 py-2 rounded-lg `}>Par trajet</button>
                <button onClick={() => changeColorBg("camion")} className={`${selectedTab === "camion" ? "bg-redFull text-white" : "bg-redFullClair2 text-redFull cursor-pointer"} bs  px-10 py-2 rounded-lg `}>Par camion</button>
            </div>
            <div className='p-4'>
                <div className='w-full m-auto p-4 border rounded-lg bg-white overflow-y-auto'>
                    <div className='my-3 p-2 grid md:grid-cols-7 sm:grid-cols-5 grid-cols-5 items-center justify-between cursor-pointer'>
                        <span className='flex justify-between'>
                            <span>Depart</span>
                        </span>
                        <span className='sm:text-left text-right'>Destination</span>
                        <span className='hidden md:grid'>Date de départ</span>
                        <span className='hidden sm:grid'>Date d'arrivée</span>
                        <span className='sm:text-left text-right'>Litres consommées</span>
                        <span className='hidden md:grid'>Coût essence</span>
                        <span className='hidden sm:grid'>Coût usure</span>
                    </div>
                    <ul>
                        {data.map((order, id) => (
                            <li key={id} className='bg-gray-50 hover:bg-gray-100 rounded-lg my-3 p-2 grid md:grid-cols-7 sm:grid-cols-3 grid-cols-2 items-center justify-between cursor-pointer'>
                                <div className='flex items-center'>
                                    <div className='bg-redFullClair2 p-3 rounded-lg'>
                                        <BsTruck className='text-redFull' />
                                    </div>
                                    <p className='pl-4'>{order.departLieu}</p>
                                </div>
                                <p className='text-gray-600 sm:text-left text-right'>{order.destinationLieu}</p>
                                <p className='hidden md:flex'>{order.dateDepart}</p>
                                <p>{order.dateDestination}</p>
                                <p className='text-gray-600 sm:text-left text-right'>{order.nbLitre}</p>
                                <p className='hidden md:flex'>{order.coutEssence}</p>
                                <p className='text-gray-600 sm:text-left text-right'>{order.usure}</p>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default table;