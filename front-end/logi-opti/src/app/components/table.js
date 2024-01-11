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

    const formatDate = (isoDateString) => {
        if (!isoDateString) return ""; // Gérer le cas où la date est indéfinie
      
        const dateObj = new Date(isoDateString);
      
        // Réglages pour le formatage de la date
        const options = {
          day: 'numeric',
          month: 'long',
          year: 'numeric',
          hour: 'numeric',
          minute: 'numeric',
          second: 'numeric',
          timeZone: 'UTC'  // Spécifiez le fuseau horaire UTC
        };
      
        const dateFormatter = new Intl.DateTimeFormat('fr-FR', options);
        return dateFormatter.format(dateObj);
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
                    {data.length === 0 ? (
                        <p>Aucune donnée disponible.</p>
                    ) : (
                        <ul>
                            {data.map((order, id) => (
                                <li key={id} className='bg-gray-50 hover:bg-gray-100 rounded-lg my-3 p-2 grid md:grid-cols-7 sm:grid-cols-3 grid-cols-2 items-center justify-between cursor-pointer'>
                                    <div className='flex items-center'>
                                        <div className='bg-redFullClair2 p-3 rounded-lg'>
                                            <BsTruck className='text-redFull' />
                                        </div>
                                        <p className='pl-4'>{order.startAddress?.city}</p>
                                    </div>
                                    <p className='text-gray-600 sm:text-left text-right'>{order.endAddress?.city}</p>
                                    <p className='hidden md:flex'>{formatDate(order.start_date?.date)}</p>
                                    <p>{formatDate(order.end_date?.date)}</p>
                                    <p className='text-gray-600 sm:text-left text-right'> {order.fuelVolume !== undefined ? order.fuelVolume.toFixed(2) + ' L' : ''}</p>
                                    <p className='hidden md:flex'>{order.energy_cost} €</p>
                                    <p className='text-gray-600 sm:text-left text-right'>{order.using_cost} €</p>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </div>
        </div>
    );
};

export default table;