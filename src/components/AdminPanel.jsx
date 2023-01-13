import { Button, TextField } from "@mui/material";
import AddIcon from '@mui/icons-material/Add';
import Snackbar from '@mui/material/Snackbar';
import { useState } from "react";

const AdminPanel = () => {

    const [value, setValue] = useState('');
    const [file, setFile] = useState([]);
    const [lblFile, setLblFile] = useState('lbl_file');
    const [valueInput, setValueInput] = useState('');
    const [valueTextarea, setValueTextarea] = useState('');
    const [styleInput, setStyleInput] = useState('');

    const [state, setState] = useState({
        open: false,
        vertical: 'top',
        horizontal: 'center',
    });
    const { vertical, horizontal, open, message } = state;

    const handleClick = (newState) => () => {
        setState({ open: true, ...newState });
    };

    const handleClose = () => {
        setState({ ...state, open: false });
    };

    const hendleChangeValueInput = (e) => {
        setValueInput(e.target.value);
        setStyleInput('');
    }
    const handleChangeValueTextarea = (e) => {
        setValueTextarea(e.target.value);
    }
    const getNameFile = (e) => {
        const value = e.target.value.replace('C:\\fakepath\\', '');
        setValue(value);
        setFile(e.target.files);
        setLblFile('lbl_file_ok');
    }

    const restartForm = () => {
        setValue('');
        setFile('');
        setLblFile('lbl_file');
        setValueInput('');
        setValueTextarea('');
        setStyleInput('');
    }

    const sendFormData = async () => {
        file.length === 0 ? setLblFile('lbl_file_error') : setLblFile('lbl_file');
        setValueInput(valueInput.trim());
        valueInput === '' ? setStyleInput('rgb(227, 80, 80)') : setStyleInput('');
        if(file.length !== 0 && valueInput !== '') {
            const formData = new FormData();


            formData.append('img', file[0]);
            

            const response = await fetch('./backEnd/index.php', {
                method: 'POST',
                body: formData,
                body: JSON.stringify({
                    name_drink: valueInput,
                    description: valueTextarea
                })
            });

            if(!response.ok) {
                (handleClick({
                    vertical: 'top',
                    horizontal: 'right',
                    message: 'Error Response'
                  }))();
                setTimeout(() => {
                    handleClose();
                }, 3000);
                return;
            }
            
            restartForm();
            (handleClick({
                vertical: 'top',
                horizontal: 'right',
                message: 'Succeful Response'
              }))();
            setTimeout(() => {
                handleClose();
            }, 3000);
            const result = await response.json();
            console.log(result);     
        }
    }
    
    return (
        <div className="adminPanelBolck">
            <div className="">
                <TextField id="outlined-basic" label="Name drink" variant="outlined" value={valueInput} onChange={hendleChangeValueInput} style={{backgroundColor: styleInput}}/>
            </div> 
            <div className="adminpanelImgInput">
                <label className={lblFile} htmlFor="img_upload">add image</label>    
                <input className="inp_file" type="file" name="img_upload" id="img_upload" onChange={getNameFile}/>
                <span className="inp_name_file">{value}</span>
            </div>
            <textarea style={{width: '60%'}} className="txtarea_description" name="" id="" cols="30" rows="10" value={valueTextarea} onChange={handleChangeValueTextarea}></textarea>
            <div>
                <Button onClick={sendFormData} variant="contained" endIcon={<AddIcon/>}>Create post</Button>
            </div>
            <div>

      <Snackbar
        anchorOrigin={{ vertical, horizontal }}
        open={open}
        onClose={handleClose}
        message={message}
        key={vertical + horizontal}
      />
    </div>
        </div>    
    );
}

export default AdminPanel;