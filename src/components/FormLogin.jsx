import { Button, TextField } from "@mui/material";
import { useState } from "react";

const FormLogin = ({handleClose}) => {

    const [valueName, setValueName] = useState('');
    const [valuePassword, setValuePassword] = useState('');

    const handleChangeName = (e) => {
        setValueName(e.target.value);
    }
    const handleChangePassword = (e) => {
        setValuePassword(e.target.value);
    }

    const sendActions = async () => {
        const data = {
            name: valueName,
            password: valuePassword
        }
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'aplication/json',
                'ACTION': 'AUTHENTICATION'
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        console.log(result);
        setValueName('');
        setValuePassword('');
        handleClose();
    }
    return (
        <div className="formLogin">
            <TextField id="standard-basic" style={{margin: '0px 5px 10px 5px'}}  label="Name" variant="standard" value={valueName} onChange={handleChangeName}/>
            <TextField id="standard-basic" style={{margin: '0px 5px 10px 5px'}}  label="Password" variant="standard" type="password" value={valuePassword} onChange={handleChangePassword}/>
            <Button variant="outlined" onClick={sendActions}>send</Button>
        </div>
    );
}

export default FormLogin;