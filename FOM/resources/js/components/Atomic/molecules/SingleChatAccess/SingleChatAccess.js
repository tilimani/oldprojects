import React from 'react';
import './styles.scss';
import ChatAccess, {TextContainer, MainTittle, MainContent, SecondContent,Content, Text} from '../../atoms/ChatAccess/ChatAccess';
import UserPicture from '../../../UserPicture/UserPicture';

const SingleChatAccess = ({
    chat,
    openChat,
    $key
}) => {
    const {from, created_at, body} = chat;

    const formatDate = (date) => {
        let formattedDate = new Date(date);
        let now = new Date();
        let offset = now.getTimezoneOffset();
        let offsetHours = (offset - (offset%60))/60;
        let offsetMinutes = offset%60;
        formattedDate.setHours(formattedDate.getHours() - offsetHours);
        formattedDate.setMinutes(formattedDate.getMinutes() - offsetMinutes);     
        if(now.getMonth() > formattedDate.getMonth() || now.getDate()>formattedDate.getDate()){
            return ('0' + formattedDate.getDate()).slice(-2) + "/"+ ('0' + formattedDate.getMonth()).slice(-2) + "/" + formattedDate.getFullYear().toString().slice(-2);            
        }
        return ('0' + formattedDate.getHours()).slice(-2) + ":" + ('0' + formattedDate.getMinutes()).slice(-2);
    };
    return (
        <div onClick={(e) => openChat(from)} key={$key}>
            <ChatAccess>
                {/* <UserPicture/> */}
                <TextContainer>
                    <MainTittle>
                        <MainContent>
                            <Text capitalize={true} text={from}/>
                        </MainContent>
                        <SecondContent>
                            <Text text={formatDate(created_at)}/>
                        </SecondContent>
                    </MainTittle>
                    <MainContent>
                        <Content>
                            <Text text={body}/>
                        </Content>
                    </MainContent>
                </TextContainer>
            </ChatAccess>
        </div> 
    );
};

export default SingleChatAccess;