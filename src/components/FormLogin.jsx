import { Button, TextField } from "@mui/material";
import { useState } from "react";

const FormLogin = ({handleClose, changeTolog}) => {

    const [valueName, setValueName] = useState('');
    const [valuePassword, setValuePassword] = useState('');

    const handleChangeName = (e) => {
        setValueName(e.target.value);
    }
    const handleChangePassword = (e) => {
        setValuePassword(e.target.value);
    }

   const sendDataUser = async () => {
        const data = {
            name: valueName,
            password: valuePassword
        }
        handleClose();
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'aplication/json',
                'ACTION': 'AUTHENTICATION'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if(response.result === 'OK') {
            changeTolog(result.token);
            console.log(document.cookie.TokenSet);
        }
   }

    return (
        <div className="formLogin">
            <TextField id="standard-basic" style={{margin: '0px 5px 10px 5px'}}  label="Login" variant="standard" value={valueName} onChange={handleChangeName}/>
            <TextField id="standard-basic" style={{margin: '0px 5px 10px 5px'}}  label="Password" variant="standard" type="password" value={valuePassword} onChange={handleChangePassword}/>
            <Button variant="outlined" onClick={sendDataUser}>send</Button>
        </div>
    );
}

export default FormLogin;