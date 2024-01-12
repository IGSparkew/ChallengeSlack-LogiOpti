import React from 'react'

const TopCards = ({dataGlobal}) => {
    return (
        <div className='grid lg:grid-cols-6 gap-4 p-4'>
            <div className='lg:col-span-2 col-span-1 bg-white flex justify-between w-full border p-4 rounded-lg'>
                <div className='flex flex-col w-full pb-4 '>
                    <p className='text-2xl font-bold'>
                        {dataGlobal.volume_essence_total !== undefined
                    ? dataGlobal.volume_essence_total.toFixed(2) + " L"
                    : ""}
              </p>
                    <p className='text-gray-600'>Litre total consommée</p>
                </div>
            </div>
            <div className='lg:col-span-2 col-span-1 bg-white flex justify-between w-full border p-4 rounded-lg'>
                <div className='flex flex-col w-full pb-4 '>
                    <p className='text-2xl font-bold'>{dataGlobal.cout_essence_total !== undefined
                    ? dataGlobal.cout_essence_total.toFixed(2) + " €"
                    : ""}</p>
                    <p className='text-gray-600'>Cout total de l’essence</p>
                </div>
            </div>
            <div className='lg:col-span-2 bg-white flex justify-between w-full border p-4 rounded-lg'>
                <div className='flex flex-col w-full pb-4 '>
                    <p className='text-2xl font-bold'>{dataGlobal.cout_usure_total !== undefined
                    ? dataGlobal.cout_usure_total.toFixed(2) + " €"
                    : ""}</p>
                    <p className='text-gray-600'>Cout d’usure total</p>
                </div>
            </div>
        </div>

    )
}

export default TopCards