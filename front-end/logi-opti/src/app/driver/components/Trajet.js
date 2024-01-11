'use client'
import { useState } from "react";

export default function Trajet({infosTrajet,setOpen}) {

    return (
        <>
            <div onClick={() => setOpen(true)} className=" px-4 rounded py-6 bg-redFullClair u-m">
                <p className="text-sm">{infosTrajet}</p>
            </div>
        </>
    );

}