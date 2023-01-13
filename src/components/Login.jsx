import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import LoginIcon from '@mui/icons-material/Login';
import DialogTitle from '@mui/material/DialogTitle';
import Dialog from '@mui/material/Dialog';
import AdminPanelSettingsIcon from '@mui/icons-material/AdminPanelSettings';
import PropTypes from 'prop-types';
import { useState } from 'react';
import FormLogin from './FormLogin';
import { Link } from 'react-router-dom';


function SimpleDialog(props) {
    const { onClose, selectedValue, open } = props;
  
    const handleClose = () => {
      onClose(selectedValue);
    };
  
    return (
      <Dialog onClose={handleClose} open={open}>
        <DialogTitle>Login</DialogTitle>
            <FormLogin handleClose={handleClose}/>
      </Dialog>
    );
  }

SimpleDialog.propTypes = {
    onClose: PropTypes.func.isRequired,
    open: PropTypes.bool.isRequired,
    selectedValue: PropTypes.string.isRequired,
  };


const Login = () => {

    const [justifyContent, setJustifyContent] = useState('space-around');
    const [token, setToken] = useState(null);

    const [open, setOpen] = useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

  const handleClose = () => {
    setOpen(false);
  };
 console.log(document.cookie);
    return (
        <>
        <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static">
                <Toolbar style={{justifyContent: justifyContent}}>
                    <p className='navHeader'>БУХЛИЩЕ ВИНИЩЕ</p>
                    <Link to={'adminPanel'}><AdminPanelSettingsIcon/></Link>
                    <LoginIcon className='loginIcon' onClick={handleClickOpen}/>
                </Toolbar>
            </AppBar>
        </Box>
        <SimpleDialog
        open={open}
        onClose={handleClose}
      /></>
  );
}

export default Login;